<?php
	$scr = strtolower($_SERVER["SCRIPT_NAME"]);
	echo ucfirst($scr);
	echo "<br>";
	echo ucfirst(substr($scr,1));
?>

