<?php
	define(END_EMAIL,'suporte@seusite.com.br');
	define(REF_EMAIL,'Erro Usuário!!!');
	define(DEST_EMAIL,'admin@seusite.com.br');
	define(ARQUIVO_LOG,'log_erros.txt');
	function trata_erro($_msg,$_tipo=0) {
		// Conforme o tipo envia a mensagem de erro
		switch($_tipo) {
			case 0:  	error_log($_msg);
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
		$_tipos = Array( 	1 => 'E_ERROR' , 
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
		trata_erro("<span style='color: #ff0000;font-weight:bold;'>Erro(" . $_tipos[$_e] . 
					"): <br/>$_msg<br/>Na linha $_linha	do arquivo $_arq</span>",1);
	}

	set_error_handler("erro_h",256|512|1024);

	function valida_usuario_senha($_usr,$_snh,$_conn) {
		$_sql = "SELECT * FROM Usuario WHERE usr_id = $_usr";
		$_res = @mysql_query($_sql,$_conn);
		if($_res===FALSE) {
			trigger_error(mysql_error($_conn),256);
			return FALSE;
		}
		elseif(mysql_numrows($_res)==0) {
			trigger_error("Usuário $_usr Não existe",1024);
			return FALSE;
		}
		else {
			$_d = mysql_fetch_array($_res);
			if(trim($_d["SENHA"])!=trim($_snh)) {
				trigger_error("Senha de $_usr Não confere...",512);
				return FALSE;
			}
			else {
				return TRUE;
			}
		}
	}

	// Exemplos
	$_conn = mysql_connect("localhost","root","");
	if($_conn===FALSE) {
		trata_erro("Erro na conexão com o Banco de dados: " . mysql_error($_conn) . "\n",3);
	}
	else {
		mysql_select_db("meu_banco_dados",$_conn);
		valida_usuario_senha("walace.soares","walaceX",$_conn);
	}

?>
