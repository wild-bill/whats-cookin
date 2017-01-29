<p><h3><?php echo $post->recipe_name; //case sensitive?></h3></p>
<p><?php echo $post->recipe_description; ?></p>
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
	
	echo "<h4>Ingredients</h4>";
	foreach ($ingredientPost as $value){
		echo "$value, ";
	}
	echo "<br />\n";
	echo "<h4>Steps</h4>";
	$i=0;
	foreach ($stepPost as $value){
		if($i++ %2 == 0){
			//if the index is an even number, it's a step no
			echo "Step No. $value<br />\n";
		}
			//if the index is an odd number, it's a step description
		else{
			echo "$value<br />\n";
		}
		
	}
	
	
	?>

<form action="" method="post">
    <input type="submit" value="Send details to embassy" />
    <input type="hidden" name="button_pressed" value="1" />
</form>

<?php

if(isset($_POST['button_pressed']))
{
    $to      = 'doctor.gill.bates@gmail.com';
    $subject = 'the subject';
    $message = 'hi sweetie pie';
    $headers = 'From: doctor.gill.bates@gmail.com' . "\r\n" .
        'Reply-To: doctor.gill.bates@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

    echo 'Email Sent.';
}

?>

