<?php
	$valor = 10;
	function dobro() {
	    $valor = 6;
		$valor = $valor * 2;
		echo "\$valor na função " . __FUNCTION__ . " = " . $valor;
	}
	echo "\$valor = $valor <br>";
	dobro();
	echo "<br>\$valor = $valor <br>";
?>
