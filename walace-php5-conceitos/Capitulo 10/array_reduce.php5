<?php
	function soma_quadrado($_ta,$v) {
		return $_ta + pow($v,2);
	}
	$_arr = Array(2,3,5,1,8,2,-1,-10);
	echo array_reduce($_arr,"soma_quadrado");
	echo "<br/>";
	echo array_reduce($_arr,"soma_quadrado",9);
?>
