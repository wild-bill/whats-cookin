<!--Slide Show -->
<!--<section>
	<img class="mySlides" src="views/meal1.jpg" style="width:100%">
	<img class="mySlides" src="views/meal2.png" style="width:100%">
	<img class="mySlides" src="views/meal3.jpeg" style="width:100%">
</section>	-->


<!-- Let the recipe nonsense begin...take out some of this code eventually it looks terrible!-->
<div class="name"><p>
<?php echo $post->recipe_name; //case sensitive?></p></div>
<div class="description"><p>Feeds:  scale factor	| Takes:(recipe times, summed)  </p></div>
<div class="description"><p><?php echo $post->recipe_description; ?></p></div>
<p><?php //echo $secondPost->recipe_description; ?></p>
<p><?php //echo $post->step_no; ?>
<p><?php //echo $post->step_instructions; ?>
<p><?php //echo $post->step_instructions; ?>
<p><?php //echo $post->step_instructions; ?>
<p><?php //echo $post->step_no; //this is only showing step1, I think I may need to store this as an array and then explode it or something?>
<?php  //print_r($secondPost); //this is for printing the entire array at once?>
<?php  //echo $secondPost['']; //this is for printing the entire array at once?>
<?php  //print_r($stepPost); echo("<br />");echo(count($stepPost)); echo("<br />");print_r(array_keys($stepPost)); //this line prints stuff for debugging mainly
//this is for printing the entire steps array at once?>
<?php 
	echo "<div class=\"ingredients\">";
	echo "<h4>Ingredients</h4>";
	foreach ($ingredientPost as $value){
		foreach ($value as $subvalue){
			echo $subvalue." "; // here this is not an object. I don't know why. In email, it is an object and must be treated like an object
		}
		echo "<br />";
	}
	echo "</div>";
	echo "<br />\n";
	echo "<h4>Steps</h4><ul id = \"myUL\">";
	$i=0;
	foreach ($stepPost as $value){
		if($i++ %2 == 0){
			//if the index is an even number, it's a step no
			echo "<li>Step No. $value<br />\n";
		}
			//if the index is an odd number, it's a step description
		else{
			echo "$value</li>\n";
		}
		
	}
	echo "</ul>";
?>