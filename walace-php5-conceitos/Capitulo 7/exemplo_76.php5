<?php
	function quadrado($valor) {
		return pow($valor,2);
	}

	if(function_exists("quadrado")) {
		echo "A função Quadrado existe e o resultado de quadrado(5) é " .
			quadrado(5) . "<br>";
	}

	if(function_exists("mysql_connect")) {
		echo "A função mysql_connect está disponivel <br>";
	}

	if(function_exists("minha_função")) {
		echo "A função minha_função existe";
	}
	else {
		echo "oops.. A função minha_função não existe...";
	}

?>
