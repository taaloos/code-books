<?php
	$_pop3 	= imap_open("{serivor_pop3:110/pop3/notls}INBOX","user","senha");

	$_id = $_GET["id"];	 
	$_pid = $_GET["parte"];
	
	$_msg = imap_header($_pop3,$_id);
	
	if($_msg===FALSE) {
		echo "A Mensagem não existe!";
	} else {
		$_st = imap_fetchstructure($_pop3,$_id); 
		$_parte = $_st->parts[$_pid-1];
		$_msg = imap_fetchbody($_pop3,$_id,$_pid);
		if($_parte->ifdparameters){
			$dpara = $_parte->dparameters;
			for ($v=0;$v<sizeof($dpara);$v++) {
				if (eregi("filename", $dpara[$v]->attribute)) 
					$fname = $dpara[$v]->value;
			}
		}  
		// definir o tipo...
		$_c = $_parte->encoding; 
		if($_c==0) { 
   			$_msg = imap_7bit($_msg); 
		} elseif($_c==1) { 
   			$_msg = imap_8bit($_msg); 
		} elseif($_c==2) { 
   			$_msg = imap_binary($_msg); 
		} elseif ($_c==3) { 
   			$_msg = imap_base64($_msg); 
		} elseif($_c==4) { 
		   	$_msg = quoted_printable($_msg); 
		}		
		
		$type = $_parte->type;
		if ($type==3) { 
   			$type = "application/"; 
		} elseif ($type==4) { 
   			$type = "audio/"; 
		} elseif ($type==5) { 
		   $type = "image/"; 
		} elseif ($type==6) { 
		   $type = "video"; 
		} elseif($type==7) { 
		   $type = "other/"; 
		} 
		$type .= $_partert->subtype; 

		Header("Content-Type: $type");
		Header("Content-Disposition: attachment;  filename=$fname");
		echo $_msg;
	}	
	
	imap_close($_pop3);
?> 
