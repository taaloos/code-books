<?php
	$valor = "FFBBAA";
	$s = substr(chunk_split($valor,2,":"),0,-1);
	echo $s;
?>
