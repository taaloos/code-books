<?php
		$i = 10;  // Inteiro
		$nome = "Walace";  // String
		$falso = FALSE;  // Booleano
		$valor = 100.50; /// Ponto flutuante
		$nulo = NULL;
		echo '$i é do Tipo ' . gettype($i) . '<br>';
		echo '$nome é do Tipo ' . gettype($nome) . '<br>';
		echo '$falso é do Tipo ' . gettype($falso) . '<br>';
		echo '$nulo é do Tipo ' . gettype($nulo) . '<br>';
		echo '$valor é do Tipo ' . gettype($valor);
		if(is_scalar($nulo)) echo "<br>NULO é escalar tb";
		
		
?>
