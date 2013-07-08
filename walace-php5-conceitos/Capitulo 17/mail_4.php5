<?php
	$_pop3 	= imap_open("{serivor_pop3:110/pop3/notls}INBOX","user","senha");
	
	$_nm = imap_num_msg($_pop3);

	set_time_limit(0);
		
	if($_nm>0) {							
		echo '<table border=1 cellspacing=3 cellpadding=3>
				<tr bgcolor="#e0e0e0">	 
					<td>MSG</td>
					<td>Remetente</td>
					<td>Data</td>
					<td>Assunto</td>
				</tr>';
		for($_i=1;$_i<=$_nm;$_i++) {
			$_msg = imap_header($_pop3,$_i); 
			$_new = ($_msg->Recent=="N"||$_msg->Unseen=="U");
			$_bgc = ($_new ? "#ffffcc" : "#ffffff");  
			$_a   = "<a href=\"ver_mensagem.php5?id=$_i\">";
			echo "<tr bgcolor='$_bgc'>";	 
			echo "<td>$_a{$_i}</a></td>";
			echo "<td>{$_msg->fromaddress}</td>";
			echo "<td>" . date("d-m-Y H:i:s",$_msg->udate) . "</td>";
			echo "<td>{$_msg->subject}</td>";
			echo "</tr>";
		}
		echo "</table>";
	} else {
		echo "Nenhuma mensagem disponível";
	} 
?> 
