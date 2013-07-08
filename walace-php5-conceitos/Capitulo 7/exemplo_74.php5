<?php
	// Cria a função
	$func = create_function('$valor,$exp','return "$valor elevado a $exp é igual à " . pow($valor,$exp) . "<br>";');
		
	echo "Nome da função: $func  <br>";
	echo $func(13,5);
	echo $func(5,7);
	echo $func(2,10);
?>
