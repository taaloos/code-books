<?php
	define("VALOR",10);
	define("FRUTA","Manga",True);
	echo "Fruta = " . fruta; // ou Fruta ou FRUTA
	echo "<br>";
	echo "Valor = " . VALOR; // Ok
	echo "<br>";
	echo "Valor = " . Valor; // Não irá funcionar
    define("VALOR",990);
	echo VALOR;	
?>

