<?php
DEFINE(VALOR,"SUCO");
	function sabor($tipo=VALOR, $sabor="Laranja") {
		echo "O Sabor do $tipo escolhido foi $sabor <br>";
	}
	sabor();
	sabor("Sorvete","Flocos");
	sabor("Chocolate"); 
?>
