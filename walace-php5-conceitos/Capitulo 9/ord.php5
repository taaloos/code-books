<?php
	$texto = "Walace Soares - PHP5";
	for($i=0;$i<strlen($texto);$i++)  {
		echo $texto[$i] . " (" . ord($texto[$i]) . ") ";
	}
?>
