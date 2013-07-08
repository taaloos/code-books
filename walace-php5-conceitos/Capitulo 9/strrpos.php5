<?php
	$texto = "Exemplo de strrpos e strripos - Livro PHP 5";
	$s1 = strrpos($texto,"p");
	$s2 = strripos($texto,"p");
	echo "strpos() : $s1 <br>";
	echo "stripos(): $s2";
?>

