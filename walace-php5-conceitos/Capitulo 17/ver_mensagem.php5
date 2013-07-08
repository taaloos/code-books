<?php
	$_pop3 	= imap_open("{serivor_pop3:110/pop3/notls}INBOX","user","senha");

	$_id = $_GET["id"];
	
	$_msg = imap_header($_pop3,$_id);
	
	if($_msg===FALSE) {
		echo "A Mensagem não existe!";
	} else {
		echo '<table border=1 cellspacing=3 cellpadding=3>
				<tr bgcolor="#e0e0e0">	 
					<td>MSG</td>
					<td>Remetente</td>
					<td>Data</td>
					<td>Assunto</td>
				</tr>';
		$_new = ($_msg->Recent=="N"||$_msg->Unseen=="U");
		$_bgc = ($_new ? "#ffffcc" : "#ffffff");  
		echo "<tr bgcolor='$_bgc'>";	 
		echo "<td>{$_id}</td>";
		echo "<td>{$_msg->fromaddress}</td>";
		echo "<td>" . date("d-m-Y H:i:s",$_msg->udate) . "</td>";
		echo "<td>{$_msg->subject}</td>";
		echo "</tr>";
		// Detalhes da mensagem...
		$_st = imap_fetchstructure($_pop3,$_id); 
		if($_st->type==0) {
			echo "<tr><td colspan=4>" . imap_body($_pop3,$_id) . "</td></tr>";
		} else {								 
			$_anexos = Array();
			echo "<tr bgcolor='#e0e0e0'>
					<td colspan=4 style='color: #0000ff;font-weight:bold;'>
					  Texto da mensagem</td>
				  </tr>";
			foreach($_st->parts as $_k=>$_parte) {
				// devemos ler cada uma das partes... 
				if($_parte->type==0) {
					// texto da mensagem...
					$_body = imap_fetchbody($_pop3,$_id,$_k+1);	
					echo "<tr><td colspan=4>{$_body}</td></tr>";
				} else {
					// Anexo... vamos guardar...
					if($_parte->ifdparameters){
                       $dpara = $_parte->dparameters;
                       for ($v=0;$v<sizeof($dpara);$v++){
                         if (eregi("filename", $dpara[$v]->attribute)) 
                             $fname = $dpara[$v]->value;}
                   	}
					$_anexos[] = Array($fname,$_k+1);	   
				}
			}
			if(sizeof($_anexos)>0) {
				// mostrar os anexos
				echo "<tr bgcolor='#e0e0e0'>
						<td colspan=4 style='color: #0000ff;font-weight:bold;'>Anexos:
						</td>
					  </tr>";
				foreach($_anexos as $_anexo) {
					echo "<tr>
							<td colspan=4>
								<a href=\"ver_anexo.php5?id={$_id}&parte={$_anexo[1]}\">
						 		{$_anexo[0]}</a>
							</td>
						  </tr>";
				}
			}
		}
		echo "</table>";
	}	
	
	imap_close($_pop3);
?> 
