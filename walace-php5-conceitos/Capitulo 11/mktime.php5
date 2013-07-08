<?php
	$_data = mktime(10,0,0,8,1,2004);
	//echo date("d-M-Y H:i:s ",$_data);
	//echo "<br/>";
	$_dia = 1;
	$_mes = 8;
	$_ano = 2004;
	$_dias  = Array(0,45,60,75,90);
	foreach($_dias as $_k=>$_v) {
	   $_vencto = mktime(0,0,0,$_mes,$_dia+$_v,$_ano);
	   echo	"Vencimento #" .  ($_k+1) . ":  " . 
			date("d/m/Y",$_vencto) . "<br/>";
	}
?>
