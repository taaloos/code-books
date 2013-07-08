<?php
	function minha_função() {
		echo "Função " . __FUNCTION__;
		echo "<br>"; 
	}

	function dobro($valor) {
		return $valor*2;
	}

	$func = "minha_função";	
	$func();
	$func = "dobro";
 	$vlr = 12;
 	echo "O dobro  de $vlr é " . $func($vlr);
?>
