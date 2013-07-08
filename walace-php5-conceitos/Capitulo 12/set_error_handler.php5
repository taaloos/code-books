<?php
	define(END_EMAIL,'suporte@seusite.com.br');
	define(REF_EMAIL,'(set_error_hamdler:Erro no SITE!!!');
	define(DEST_EMAIL,'admin@seusite.com.br');
	define(ARQUIVO_LOG,'log_erros.txt');

	function trata_erro($_msg,$_tipo=0) {
		// Conforme o tipo envia a mensagem de erro
		switch($_tipo) {
			case 0:  error_log($_msg);
						break;

			case 1:	$_extras = 'Subject: ' . REF_EMAIL . "\n"; 
						$_extras.= 'From: ' . END_EMAIL . "\n";
						$_extras.="Content-Type: text/html\n";
						error_log($_msg,1,DEST_EMAIL,$_extras);
						break;
			case 3:	error_log($_msg,3,ARQUIVO_LOG);
		}
		return TRUE;
	}
	function erro_h($_e,$_msg,$_arq,$_linha) {
		$_tipos = Array( 1 => 'E_ERROR' , 
						 2 => 'E_WARNING' , 
						 4 => 'E_PARSE' , 
						 8 => 'E_NOTICE' ,
						 16 => 'E_CORE_ERROR' ,
						 32 => 'E_CORE_WARNING' ,
						 64 => 'E_COMPILE_ERROR' ,
						 128 => 'E_COMPILE_WARNING' ,
						 256 => 'E_USER_ERROR' ,
						 512 => 'E_USER_WARNING' ,
						 1024 => 'E_USER_NOTICE' ,
						 2047 => 'E_ALL ',
						 2048 => 'E_STRICT');


		trata_erro("<span style='color: #ff0000;font-weight:bold;'>Erro(" . $_tipos[$_e] . "): <br/>$_msg<br/>Na linha $_linha do arquivo $_arq</span>",1);
	}
	set_error_handler("erro_h");
	// Erro
	$_a = 1024/$_b;
	$_c = CONSTANTE_QUALQUER;
?>
