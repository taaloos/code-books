<?php
	$texto = "Este é um texto com \' e \" e \\\ ";
	echo $texto;
	echo "<br>";
	echo stripslashes($texto) . "\ ";
?>
