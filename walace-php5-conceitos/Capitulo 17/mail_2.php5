<?php
	include_once("class_email.inc");   
	
	$_mail = new EMAIL();
	$_mail->setDestino("destino@servidor");
	$_mail->setAssunto("TESTE da classe Email");
	$_mail->setHeader("Content-Type","text/html");	
	$_mail->setHeader("Content-Transfer-Encoding","quoted-printable");
	$_mail->setMensagem("<html><body><b><big>Mensagem com arquivo anexado...</big></b></body></html>");
	$_mail->setArquivo("chess03.jpg");
	$_mail->setContentType(0,"image/jpeg"); 
	$_mail->setArquivo("sp.pdf");		   
	$_mail->setContentType(1,"application/pdf"); 
	set_time_limit(0);
	if($_mail->enviar()) {
		echo "<br/>OK..." . date("d-m-Y H:i:s");
	} else {
		echo "ERRO";
	}
?>
