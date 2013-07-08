<?php
	$i = 0;
	while($i<=15) {
		$i++;		  
		echo "<br>$i =";
		for($j=(int)($i/2);$j<$i+4;$j+=2) {
			if($j%2==0) {
				continue;
			}
			if($j==10) {
				continue 2;
			}
			echo "$j,";
		}
	}
?>

