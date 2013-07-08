<?php
	function quadrado($valor) {
		$val_orig = $valor;
		$valor *= $val_orig;
		echo "Quadrado de $val_orig é : " . $valor;
	}
	$valor = 12;
	quadrado($valor);
	echo "<br>$valor";
?>
