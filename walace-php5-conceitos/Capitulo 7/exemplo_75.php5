<?php
	function executa_função($func,$args) {
		foreach($func as $nome_func) {
			$ret .= $nome_func . ": " . $nome_func($args[0],$args[1]) . "<br>";
		}
		return $ret;
	} 

	// Vamos criar um array de funções
	$logica_1 =  'if($a>$b) { return "O Maior valor é $a"; } elseif($a==$b)	{return "São 	iguais";} else { return "O maior valor é $b";}';
	$logica_2 = 'return "$a elevado a $b = " . pow($a,$b);';
	$logica_3 = 'return "Raiz quadrada da soma dos quadrados de $a e $b é igual à " . sqrt($a*$a+$b*$b);';
	$a_func = array(create_function('$a,$b',$logica_1),
						create_function('$a,$b',$logica_2),
						create_function('$a,$b',$logica_3));
	$vlr = Array(4,3);
	echo "Resultado das funções: <br>"  . executa_função($a_func,$vlr);
?>
