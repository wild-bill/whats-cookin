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
	
  }
?>