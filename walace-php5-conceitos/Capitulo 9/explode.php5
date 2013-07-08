<?php
	$string = "Este é um exemplo da função explode no PHP";
	$v1 = explode(" ",$string);
	$v2 = explode(" ",$string,3);
	echo "<pre>";
	print_r($v1);
	print_r($v2);
	echo "</pre>";
?>
