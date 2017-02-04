<?php

	/* This is the Recipe class. It reaches out to the database and creates a Recipe object based on what is in the table. There
		is more to it than that but that is what I'll write for now.
		
		1.15.17
		So something to think about is whether or not I want to have a class for each table in the DB (I'm not sure if this is standard).
		Based on what I have, I could probably get away with just making a variable for everything I will query, but if I want to extend in 
		the future (and this is the part I'll have to think about...), then it might be worth it. 
	
	*/

  class Recipe {
    	
	//recipe table
	public $recipe_id;
	public $recipe_name;
	public $recipe_description;
	public $recipe_style;
	public $recipe_skill_level;
	public $recipe_serves;
	public $recipe_course;
	public $recipe_isHealthy;
	
	//steps table
	public $step_instructions;
	public $step_no;
	public $step_time;
	
	//step ingredients table
	
	
	//ingredients table
	public $ingredient_best_store;
	public $ingredient_id;
	public $ingredient_name;
	
	public $resultSet;
		
	
	
	

    public function __construct($recipe_id, $recipe_name, $recipe_description, $step_no, $step_instructions, $ingredient_name) {
      //$this->combined_key = $combined_key;
	  $this->recipe_id = $recipe_id;  //trying this way instead so that "id" can stay consistent.
      $this->recipe_name  = $recipe_name;
      $this->recipe_description = $recipe_description;
	  $this->step_no = $step_no;
	  $this->step_instructions = $step_instructions;
	  $this->ingredient_name = $ingredient_name;
	  
	  
	  //declare type
      $this->type    = 'recipe';
      
    }



/* I'm thinking we use this same all() function to populate lists in pages, and have a switch to decide on which table to pull from */
    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM recipe');

      // we create a list of Post objects from the database results
      foreach($req->fetchAll() as $post) {
        $list[] = new Recipe($post['Recipe_ID'], $post['Recipe_Name'], $post['Recipe_Description'], "","",""); //These should not be lowercase. Whatever didn't work earlier didn't work for a different reason
      }

      return $list;
    }

    
	public static function find_play($id) {
		/* This is my method to play with, the one below is the original one that is real and works (but obviously needs some tuning or I wouldn't be screwing around up here 1.27.17 */

	 $db = Db::getInstance();  //make the connection so to speak
      
	  $req = $db->prepare('SELECT Recipe.Recipe_ID, Recipe.Recipe_Name, Recipe.Recipe_Description, Steps.Step_No, Steps.Step_Instructions, ingredients.Ingredient_Name
							FROM Recipe 
							INNER JOIN steps on recipe.Recipe_ID = steps.Recipe_ID
							INNER JOIN step_ingredients on steps.Step_No = step_ingredients.Step_No
							INNER JOIN ingredients on step_ingredients.Ingredient_ID = ingredients.Ingredient_ID');  //trying this one out
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('recipe_id' => $id));   // This needs to be 'recipe_id' not just ID
      //$resultSet = array(); //trying to use a loop to put responses into an array
	  $post = $req->fetch();
	  //while($post = $req->fetch())
	  //{
		//	$resultSet[] = $post;
	  //}
      return new Recipe($post['Recipe_ID'], $post['Recipe_Name'], $post['Recipe_Description'], $post['Step_No'], $post['Step_Instructions'], $post['Ingredient_Name']);  //These actually need to be uppercase. Or I guess they need to match the DB names more correctly
		//$post = $resultSet;
		//return $post;
	}
	
	public static function findIngredients($id) {
		/* So the play with one works (which is really just find_orig at this point), so I am trying one to just extract the steps array, but really I used ingredients for worst case scneario. the problem was with the query more than the code 1.27.17 */
		/* fixing this method to pull in the ingredients, instead of using it as a tester method. 1/29/2017 */
		/* This method now pulls in the amounts and units as well as the ingredient name. Units need to be corrected on the backend still. Could use cleaning up overall... This next step will be figuring out how to query to SUM by same ingredients. This may not be done in a query...not sure. Want to reuse code but not overfill it 2.4.17 */

	 $db = Db::getInstance();  //make the connection so to speak
      $sql = "SELECT step_ingredients.Step_Amount, units.Description, ingredients.Ingredient_Name
					FROM Recipe INNER JOIN steps on recipe.Recipe_ID = steps.Recipe_ID 
								INNER JOIN step_ingredients on steps.Recipe_ID = step_ingredients.Recipe_ID AND steps.Step_No = step_ingredients.Step_No
								INNER JOIN ingredients on step_ingredients.Ingredient_ID = ingredients.Ingredient_ID
								INNER JOIN units on step_ingredients.UnitID = units.UnitID
								WHERE Recipe.Recipe_ID = ".$id."
								Order BY recipe.Recipe_ID asc, steps.Step_No ASC";
								
								
	  $req = $db->prepare($sql);  //trying this one out
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('recipe_id' => $id));   // This needs to be 'recipe_id' not just ID
      
	  $resultSet = array(); //create result set array that will store our results
	  
	  
	  while($ingredientPost = $req->fetch())
	  {
		$amount = $ingredientPost['Step_Amount'];
		$unit = $ingredientPost['Description'];
		$ingredient = $ingredientPost['Ingredient_Name'];
		$ingredientObj = (object) array('amount' => $amount, 'unit' => $unit, 'ingredient' => $ingredient);
		$resultSet[] = $ingredientObj;
	  }
      
		$ingredientPost = $resultSet;
		return $ingredientPost;
	}
	
	public static function findSteps($id) {
		/* This will find the steps in the recipe This works as it should now. It queries for the ingredients and puts them into a db as step_no/step_instruction pair. on the view it is printed 1,2 1,2 1,2 etc.*/

	  $db = Db::getInstance();  //make the connection so to speak
      // for some reason I have to actually prep the SQL statement here or it doesn't process right. Doesn't accept $id var in the middle of the statement if it's part of the "db->prepare" line
	  $sql = "SELECT Recipe.Recipe_ID, Recipe.Recipe_Name, Recipe.Recipe_Description, Steps.Step_No, Steps.Step_Instructions
							FROM Recipe 
							INNER JOIN steps on recipe.Recipe_ID = steps.Recipe_ID
							WHERE Recipe.Recipe_ID = ".$id."
							Order BY steps.Step_No ASC";
	  $req = $db->prepare($sql);  
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('recipe_id' => $id));   // This needs to be 'recipe_id' not just ID. This is still not working right for some reason. It's showing everything.
      
	  $resultSet = array(); //create result set array that will store our results
	  
	  while($stepPost = $req->fetch())
	  {
		$step_no = $stepPost['Step_No'];
		$step_instruction = $stepPost['Step_Instructions'];
		$resultSet[] = $step_no;
		$resultSet[] = $step_instruction;
	  }
        $stepPost = $resultSet;
		return $stepPost;
	}
	
	
	
	
	public static function find($id) {
		/* The intention of this version is to query and capture everything I need for a "Recipe" page like allrecipes or whatever */
		/* What this does is that it finds the particular recipe that is clicked on based on its id. it creates the whole recipe object, but we only take two values from it at the time. this can probably be redone and cleaned up a bit */

	 $db = Db::getInstance();  //make the connection so to speak
     //need to prep the sql (idk why I didn't notice this before) so that we can put the $id in there so it doesn't just pull everything
	 $sql = "SELECT Recipe.Recipe_ID, Recipe.Recipe_Name, Recipe.Recipe_Description, Steps.Step_No, Steps.Step_Instructions, ingredients.Ingredient_Name
							FROM Recipe 
							INNER JOIN steps on recipe.Recipe_ID = steps.Recipe_ID
							INNER JOIN step_ingredients on steps.Step_No = step_ingredients.Step_No
							INNER JOIN ingredients on step_ingredients.Ingredient_ID = ingredients.Ingredient_ID
							WHERE Recipe.Recipe_ID = ".$id."";
	  $req = $db->prepare($sql);  //use the statement
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('recipe_id' => $id));   // This needs to be 'recipe_id' not just ID. this has something to do with post but I'm not certain what to be honest
      $post = $req->fetch(); 
	  
      return new Recipe($post['Recipe_ID'], $post['Recipe_Name'], $post['Recipe_Description'], $post['Step_No'], $post['Step_Instructions'], $post['Ingredient_Name']);  //These actually need to be uppercase. Or I guess they need to match the DB names more correctly
	}
	
	
	
	public static function find2($id) {
		
		/* the original version so I can play with the other one */
		
      $db = Db::getInstance();  //make the connection so to speak
      
	  $req = $db->prepare('SELECT * FROM recipe WHERE recipe_id = :recipe_id');  //trying this one out
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('recipe_id' => $id));   // this line caused issues when attempting to show the recipes after clicking "show content". Because it needs to be 'recipe_id'
      $post = $req->fetch();

      return new Recipe($post['Recipe_ID'], $post['Recipe_Name'], $post['Recipe_Description']);  //These actually need to be uppercase. Or I guess they need to match the DB names more correctly
    }
    
    
      
    
    
  }
?>