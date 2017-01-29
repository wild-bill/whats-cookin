<?php
//display the ingredients
echo "<h4>Ingredients</h4>";
	foreach ($ingredientPost as $value){
		foreach($value as $lineitem){
			echo "$lineitem, ";
		}
	}
	foreach ($choices as $value){
		echo "$value<br />";
	}



?>