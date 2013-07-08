<?php
	$_destino  = "nome@provedor.com.br";
	$_destino .= ", outronome@provedor.com.br";
	$_assunto = "Teste de mensagem HTML";
	$_mensagem = "<H1>MENSAGEM HTML</h1>";
	$_param = "From: seuemail@provedor.com \r\n";
	$_param .= "Content-type: text/html";
	if(mail($_destino,$_assunto,$_mensagem,$_param)) {
		echo "Mensagem enviada com sucesso";
	} else {
		echo "Erro ao enviar a mensagem...";
	}
?>
