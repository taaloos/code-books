<?php
	// valida_data.php5
	foreach($_POST["data"] as $_k=>$_data) {
		$_dia = substr($_data,0,2);
		$_mes = substr($_data,3,2);
		$_ano = substr($_data,-4);
		if(checkdate($_mes,$_dia,$_ano)) {
			echo "[$_k] $_data é válida<br/>";
		}
		else {
			echo "[$_k] $_data incorreta....<br/>";
		}
	}
?>
