<?php
	$texto = "abcde";
	echo substr($texto,1,-2);
	$scr = $_SERVER["SCRIPT_NAME"];
	echo "<br>Script: $scr<br>";
	echo substr($scr,strpos($scr,".")+1,-1);
	echo "<br>";
	echo  substr($scr,-4,-1);
?>
