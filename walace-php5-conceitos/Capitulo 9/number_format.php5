<?php
	$numero = 125456.72;
	$f1 = number_format($numero);
	$f2 = number_format($numero,3);
	$f3 = number_format($numero,2,",",".");
	echo "number_format, com 1 parâmetro: $f1 ";
	echo "<br>com 2 parametros: $f2";
	echo "<br>com todos os parâmetros: $f3";
?> 
