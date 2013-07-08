<?php
	$_arr = Array(2,7,"a"=>array(5,8,9),"b",13,17,"c"=>"W");
	$a = "Teste";
	$c = 100;
	extract($_arr,EXTR_PREFIX_INVALID,"_V");
	extract($_arr,EXTR_PREFIX_ALL,"_V");			
	echo "<pre>";
	print_r($_arr);
	echo "<br/>";
	echo '$a = '  . $a;
	echo "<br/>";
	echo '$c = ' . $c;
	echo "<br/>";
	foreach($GLOBALS as $_k=>$_vlr) {
		if(substr($_k,0,3)=="_V_") {
			echo "\$$_k  = $_vlr <br/>";
		}
	}
?>
