<?php
	function hipotenusa($ca,$co) {
		return sqrt(pow($ca,2)+pow($co,2));
	}

	$a = 8;
	$b = 12;
	$func = "hipotenusa";
	$hip = call_user_func($func,$a,$b);
	echo "hipotenusa = " . $hip;
?>
