<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>The William Podcast Show</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:100,300,400">
  </head>

  <body>

       
    <section class="row-alt">
      <div class="lead container">

        <h1>
		<?php 
		$url =  "{$_SERVER['REQUEST_URI']}";

		$urly = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
		//echo $urly; ///?controller=episodes&action=index
		$split1 = explode("=", $urly);
		//echo $split1[0]."\n";
		//echo $split1[1]."\n";
		$split2 = explode("&", $split1[1]);
		echo $split2[0];
		?>
		</h1>

        <p>Take a gander at some of the sweet-ass recipes we got go'n on.</p>

      </div>
    </section>
	
	<section class="row">
    <div class="grid">
<!-- PHP Begins here -->
<?php foreach($elements as $post) { ?>
			<?php	/*displays each $element, which is... from a controller?. Spits it out as a list on the web page */ ?>
 
			<section class="speaker">

          <div class="col-2-3">
    		<?php 
			//just added in by me as a test 8.28
			/* This tests for whether or not it uses a Title, or a Name. Characters, Settings use names. Episodes, Commercials(?) use titles. It's semantics, really. */
			if(isset($post->title)){
				echo $post->title;
			}
			else{
				echo $post->recipe_name;
			}
			
			
			?>
			</div><!--

          --><aside class="col-1-3">
            <div class="speaker-info">

              <img src="diner_picture.png" alt="diner picture">

              <ul>
                <li><a href='?controller=<?php echo $post->type; ?>s&action=show&recipe_id=<?php echo $post->recipe_id; ?>'>See content</a></li> <?php //These little things need to change from id to Recipe_ID. think about extending...?>
                <li><a href="index.php">Go Back Home!</a></li>
              </ul>

            </div>
          </aside>

        </section>
    		
    		
  
<?php } ?>

      </div>
    </section>

    

  </body>
</html>



