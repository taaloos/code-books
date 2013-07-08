<?php
	function valida_cep($_cep) {
		// Valida um CEP no formato 99999-999 ou 99999999
		if(ereg("^([0-9]){5}-?([0-9]){3}$",$_cep,$_c)) {
			return Array($_c[1],$_c[2]);
		}
		else {
			return FALSE;
		}
	}

	$_cp = Array("05735-010","03578000","A0010-000","98120");
	foreach($_cp as $_cep) {
		if(($_r=valida_cep($_cep))===FALSE) {
			echo "$_cep: CEP Incorreto";
		}
		else {
			echo  "$_cep: CEP OK";
		}
		echo "<br/>";
	}
?>
