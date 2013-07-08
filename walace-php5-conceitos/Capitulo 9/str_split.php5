<?php
	$texto = "Este é um exemplo de str_split ";
	$s1 = str_split($texto);
	$s2 = str_split($texto,5);
	echo '<pre>';
	print_r($s1);
	print_r($s2);
	echo '</pre>';
?>
