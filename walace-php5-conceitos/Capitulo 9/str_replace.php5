<?php
	$texto = "PHP 5 - Guia do Programador - Editora Érica";
	$vog = array("a","e","i","o","u");
	$s1 = str_replace($vog,"_",$texto,$cont);
	$s2 = str_ireplace("php","*","$texto",$cont2);
	echo "Texto original: $texto<br>";
	echo "str_replace: $s1 . Número de substiuições: $cont <br>";
	echo "str_ireplace: " .  $s2 . " Número de substiuições: $cont2<br>";
	// Não funciona
	$texto = "ABCDEFGH";
	$s3 = stR_ireplace("a","*",$texto,$cont3);
	echo "<bR>não funciona::<br>str_ireplace: " .  $s3 . " Número de substiuições: $cont3<br>";
	$s3 = stR_ireplace("a","*","a$texto",$cont3);
	echo "<bR>funciona::<br>str_ireplace: " .  $s3 . " Número de substiuições: $cont3<br>";

?>
