<?php
	$_ini = parse_ini_file("c:\\windows\\system.ini");
	$_ini2 = parse_ini_file("c:\\PHP\php.ini",TRUE);
	echo "<pre>";
	print_r($_ini);
	echo "<br><br>";
	print_r($_ini2);
	echo "</pre>";
?>
