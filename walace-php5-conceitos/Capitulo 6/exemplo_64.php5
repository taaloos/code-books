<?php
	for($i=0;$i<=100;$i++) {
		echo "$i : ";
		for($j=$i+1;$j<$i+5;$j++) {
			echo "$j - ";
			if($j==10 or $j==15)
				break;
			elseif($j==27)
				break 2;
		}
		echo "<br>";
	}
?>

