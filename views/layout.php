<body>
  <head>
    <meta charset="utf-8">
    <title>Recipes for the Week</title>
    <link rel="stylesheet" href="../main.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:100,300,400">
  </head>

  <!--<body>-->
  <!-- Header -->
    <header class="container group">

      <h1 class="logo">
        <a href="index.php">Recipes</a>
      </h1>

    </header>
	<!-- Hero -->

    <section class="menu">
	<nav class="nav primary-nav">
        <ul>
		<li><a href="index.php">Home |</a> </li>
        <li><a href='https://soundcloud.com/williampodcastshow'>Episodes |</a></li>
        <li><a href='?controller=recipes&action=index'>Recipes |</a></li> 
        
		</ul>
     </nav>
	 </section>

	<?php require_once('routes.php'); ?>
	
	 <!-- Footer -->

    <footer class="primary-footer container group">

      <small>&copy; The William Podcast Show</small>

      <nav class="nav">
        <ul>
		<li><a href="index.php">Home |</a> </li>
        <li><a href='https://soundcloud.com/williampodcastshow'>Episodes |</a></li>
        <li><a href='comingsoon.html'>Commercials |</a></li> 
        <li><a href='comingsoon.html'>Characters |</a></li>
        <li><a href='comingsoon.html'>Settings |</a></li>
		<li><a href='comingsoon.html'>Artwork |</a></li>
		<li><a href='thanks.html'>Thanks</a></li>
		</ul>
      </nav>

    </footer>
  </body>