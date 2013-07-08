<?php
	function  saldo($valor,$acresc,$desc,$multa) {
		return ($valor + $acresc - $desc) * (1 + $multa / 100);
	}

	$v1 = array(1000,0,100,5);
	$v2 = array(500,200,0,3.5);
	$f = "saldo";
		
	$valor_1 = call_user_func_array($f,$v1);
	$valor_2 = call_user_func_array($f,$v2);
	
	echo $valor_1 . " :: " . $valor_2;
?>

