<?php

/* This is the file that will run by the cron job once a week, in effect sending an email to the people signed up */

// since we aren't using 'routes.php' (because this will almost always be a fixed action to send an email, i have to include all the related filesize
require_once('connection.php');
require_once('models/recipe.php');
require_once('controllers/recipes_controller.php');
$controller = new RecipesController(); //create new recipe controller
$action = 'email';
$controller->{ $action }();
//there's probably a nicer looking way to do this


?>