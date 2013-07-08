<?php
	$_pop3 	= imap_open("{serivor_pop3:110/pop3/notls}INBOX","user","senha");
	$_cab 	= imap_headers($_pop3);
	if($_cab===FALSE) {
		echo "Nenhuma mensagem disponível";
	} else {	
		foreach($_cab as $_k=>$_vlr) {
				echo "$_vlr <br/>";
		}
	} 
?> 
