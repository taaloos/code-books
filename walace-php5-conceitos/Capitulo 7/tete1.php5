<?php
	function minha_função() {
		echo "Esta função recebeu " . func_num_args() . " Argumentos";
		for($k=0;$k<func_num_args();$k++) {
			echo "<br>Argumento " . ($k+1) . " = " . func_get_arg($k);
		}
	}
	minha_função("a","n",10,5);
?>
