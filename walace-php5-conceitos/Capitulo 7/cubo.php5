<?php
	function & cubo($valor) {
		$cubo = $valor*$valor*$valor;
		return $cubo;
	}
	$valor = & cubo(10);
	echo "O Cubo de $valor é " . $valor;
?>
