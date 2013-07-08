<?php
	define(END_EMAIL,'suporte@seusite.com.br');
	define(REF_EMAIL,'Erro no SITE!!!');
	define(DEST_EMAIL,'admin@seusite.com.br');
	define(ARQUIVO_LOG,'log_erros.txt');

	function trata_erro($_msg,$_tipo=0) {
		// Conforme o tipo envia a mensagem de erro
		switch($_tipo) {
			case 0:  error_log($_msg);
					break;

			case 1:	$_extras = "Subject: " . REF_EMAIL . "\n"; 
					$_extras.= "From: " . END_EMAIL . "\n";
					$_extras.= "Content-Type: text/html\n";
					error_log($_msg,1,DEST_EMAIL,$_extras);
					break;
			case 3:	error_log($_msg,3,ARQUIVO_LOG);
		}
		return TRUE;
	}

	// Exemplos
	$_conn = mysql_connect("localhost","root","");
	if($_conn===FALSE) {
		trata_erro("Erro na conexão com o Banco de dados: " . mysql_error($_conn) . "\n",3);
	}
	else {
		mysql_select_db("zeus_controle_tng",$_conn);
		$_sql = "SELECT * FROM Usuario WHERE usr_id = $_id";
		$_res = @mysql_query($_sql,$_conn);
		if($_res===FALSE) {
			trata_erro("Erro no SQL $_sql : " . mysql_error($_conn) . "\n",3);
		}
	}

	trata_erro("<B>ERRO</B>",1);
?>
