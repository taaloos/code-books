<?php
	$texto = "Este é um exemplo de strpos e stripos";
	$s1 = strpos($texto,"e");
	$s2 = stripos($texto,"e");
	echo "strpos() : $s1 <br>";
	echo "stripos(): $s2";
?>
