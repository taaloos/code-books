<?php
	$var = "Carol";
	$nome =  $var; // Atribuição direta (cópia)
	$Nome = & $var; // Atribuição por referencia
	$nome = "Isabelle"; // só modifica $nome, $var continua = "Carol"
	$Nome = "Anna Carolina"; // $var é modificada também
	echo "\$var  = $var <br>";  
	echo "\$nome = $nome <br>";
	echo "\$Nome = $Nome <br>";
?>
