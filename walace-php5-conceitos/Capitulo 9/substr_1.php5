<?php
	$scr = $_SERVER["SCRIPT_NAME"];
	if(strtolower(substr($scr,-4))=="php5" OR
	   strtolower(substr($scr,0,3))=="php") {
			echo "Este é um programa PHP";
	}
	else {
		echo $scr;
	}
?>
