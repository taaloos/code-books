<?php
	$texto = "PHP5 - Guia do Programador";
	$s1 = str_word_count($texto);
	$s2 = str_word_count($texto,1);
	$s3 = str_word_count($texto,2);
	echo "Total de palavra no texto: $s1 <br>";
	echo "<pre>";
	print_r($s2);
	print_r($s3);
	echo "</pre>";
?>	
