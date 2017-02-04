<?php

//$to = 'doctor.gill.bates@gmail.com, mollylaflesh@gmail.com, william.kryjak@gmail.com';
//$to = 'doctor.gill.bates@gmail.com, william.kryjak@gmail.com'; // note the comma
$to = 'doctor.gill.bates@gmail.com';
// Subject
$subject = 'Meal Ingredients for the week';

// Message
$messageStart = "
<html>
<head>
  <title>Where will this display?</title>
</head>
<body>
<h4>Ingredients</h4>";

$messageEnd = "</body>
</html>";
ob_start();
//display the ingredients
	foreach ($ingredientPost as $value){
		foreach($value as $lineitem){
			echo "$lineitem, ";
		}
	}
//display the recipe names and links	
	echo "<br />";
	$length = count($choices);
	for($i=0; $i<$length; $i++){
		//print_r ($value);
		//echo($choice);
		echo "<br /><a href=\"http://localhost:8080/recipes/index.php?controller=recipes&action=show&recipe_id=".$choice."\">".$names[$i]."</a>"; //the recipe name has to be taken diff. this takes the id'th place in the array which is not correct because the array is [0,1]. tried subtracting 1 to offset array and still getting error
	}
//
$displayed = ob_get_clean();

$fullMessage = $messageStart . $displayed . $messageEnd;

echo $fullMessage;
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
//$headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
$headers[] = 'From: Wha\'ts Cookin\'?" <birthday@example.com>';
//$headers[] = 'Cc: birthdayarchive@example.com';
//$headers[] = 'Bcc: birthdaycheck@example.com';

// Mail it
//mail($to, $subject, $fullMessage, implode("\r\n", $headers));

?>