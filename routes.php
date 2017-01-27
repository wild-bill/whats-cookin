<?php
  function call($controller, $action) {
    require_once('controllers/' . $controller . '_controller.php');

    switch($controller) {
      case 'pages':
        $controller = new PagesController();
      break;
      case 'posts':
        // we need the model to query the database later in the controller
        require_once('models/post.php');
        $controller = new PostsController();
      break;
      case 'episodes':
        // we need the model to query the database later in the controller
        require_once('models/episode.php');
        $controller = new EpisodesController();
      break;
      case 'commercials':
        // we need the model to query the database later in the controller
        require_once('models/commercial.php');
        $controller = new CommercialsController();
      break;
      case 'settings':
        // we need the model to query the database later in the controller
        require_once('models/setting.php');
        $controller = new SettingsController();
      break;
      case 'artworks':
        // we need the model to query the database later in the controller
        require_once('models/artwork.php');
        $controller = new ArtworksController();
      break;
      case 'characters':
        // we need the model to query the database later in the controller
        require_once('models/character.php');
        $controller = new CharactersController();
      break;
	  case 'recipes':
        // we need the model to query the database later in the controller
        require_once('models/recipe.php');
        $controller = new RecipesController();
      break;
    }

    $controller->{ $action }();
  }

  // we're adding an entry for the new controller and its actions
  $controllers = array('pages'       => ['home', 'error'],
                       'posts'       => ['index', 'show'],
                       'episodes'    => ['index', 'show'],
                       'commercials' => ['index', 'show'],
                       'settings'    => ['index', 'show'],
                       'artworks'    => ['index', 'show'],
                       'characters'  => ['index', 'show'],
					   'recipes'     => ['index', 'show']);

  if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
      call($controller, $action);
    } else {
      call('pages', 'error');
    }
  } else {
    call('pages', 'error');
  }
?>