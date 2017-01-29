<?php
  class RecipesController {
    public function index() {
      // we store all the posts in a variable
      $elements = Recipe::all();
      
      require_once('views/posts/index.php');
    }

    public function show() {
      // we expect a url of form ?controller=posts&action=show&id=x
      // without an id we just redirect to the error page as we need the post id to find it in the database
      if (!isset($_GET['recipe_id']))
        return call('pages', 'error');

      // we use the given id to get the right post
      $post = Recipe::find($_GET['recipe_id']);
	  $stepPost = Recipe::findSteps($_GET['recipe_id']); //pull in the steps
	  $ingredientPost = Recipe::findIngredients($_GET['recipe_id']); //can prob put recipe id into a variable

      require_once('views/posts/show.php');
    }
	
	public function email() {
	/* So I'm not sure if I'm doing this totally right, but I think the email info needs to be driven off of this controller since
		it is also make queries from the db and using the same kind of underlying infrastructure with the recipe class. The trick is that
		rather than display a webpage that you can go visit, it's going to assemble html that will then be emailed. so i only want it to run
		when the script tells it to. */
		
		/* it may need to take "choices" as a parameter but i haven't figured this out yet */
		$choices = array();
		$choice = rand(1,3); //make the parameters line up with the loop you will eventually put here instead of hard coded numbers
		$choices[] = $choice;
		$choice = rand(1,3);
		$choices[] = $choice;
		//currently it doesn't do the error check because I don't know that it will be passed via post. that said, it is probably worth putting in some tpye of check so people can't just type it into the browser
		foreach ($choices as $value){
			$ingredientPost[] = Recipe::findIngredients($value);
		}
		//$ingredientPost = Recipe::findIngredients($_GET['recipe_id']);//so instead of getting the recipe_id, it needs to be given multiple options. that means its going to have to be an array as an input which means more CODING for me. no. it will loop through an array of inputs
		require_once('views/email.php');
	
	}
	
	
	
  }
?>