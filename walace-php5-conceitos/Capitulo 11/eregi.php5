<?php
	function valida_usuario($_usr) {
		// Valida uma string como nome ou senha do usuário
		// o qual só deve conter letrase números 
		// sendo possível no minimo 4 e no Maximo 10 caracteres
		if(eregi("^([a-z0-9]){4,10}$",$_usr)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	if(($_r=valida_usuario("00"))===FALSE) {
			echo "Nome inválido";
	}
	else {
		echo  "OK";
	}
?>
