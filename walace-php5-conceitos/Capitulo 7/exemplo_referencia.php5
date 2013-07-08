<?php
	function quadrado($valor) {
		$val_orig = $valor;
		$valor *= $val_orig;
		echo "Quadrado de $val_orig é : " . $valor;
	}
	$valor = 15;
	echo "Valor original:  $valor <br>";
	quadrado(& valor);
	echo "<br>Valor atual: $valor";
?>
