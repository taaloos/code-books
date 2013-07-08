<?php
	$valor = 10;
	function dobro() {
		global $valor;
		$valor = 6;
		$valor = $valor * 2;
		echo "\$valor na função " . __FUNCTION__ . " = " . $valor;
	}
	function metade() {
		$GLOBALS["valor"] = $GLOBALS["valor"] / 2;
		echo "\$valor na função " . __FUNCTION__ . " = " . $GLOBALS["valor"];
	}
	echo "\$valor = $valor <br>";
	dobro();
	echo "<br>\$valor = $valor <br>";
	metade();
	echo "<br>\$valor = $valor";
?>
