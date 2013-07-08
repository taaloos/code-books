<?php
	function minha_função() {
		echo __FUNCTION__;
	}
	$func = get_defined_functions();

	echo "<pre>";
	print_r($func["user"]);
	print_r($func["internal"]);
	echo "</pre>";

	function conecta(& $con, $servidor,$usuario,$senha) {
		return $con = mysql_connnect($servidor,$usuario,$senha);
	}
?>	

