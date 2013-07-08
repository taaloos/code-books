	<?php
		$_con = @mysql_connect("localhost","root","");
		if($_con===FALSE) {
			echo "Não foi possivel conectar ao MySQL " . 
					mysql_error();
			exit;
		}		 
		
		mysql_select_db("BD_PHP5",$_con);
		if($_con===FALSE) {
			echo "Não foi possivel conectar ao Banco de Dados " . 
					mysql_error();
			exit;
		}
		
		$_sql = "SELECT * FROM Usuario";
		$_res = mysql_query($_sql,$_con);
		if($_res===FALSE) {
			echo "Erro na consulta... " . mysql_error() . "<br/>";
		} else {				  
			$_nr = mysql_num_rows($_res);
			echo "A consulta retornou " . (int) $_nr . " registro(s)<br/>";
			if($_nr>0) {
				// Primeiro o cabeçalho com os campos da tabela
				echo "<table border=1 cellspacing=3 cellpadding=2>";
				echo "<tr bgcolor='#f0f0f0'>";
				for($_i=0;$_i<mysql_num_fields($_res);$_i++) {
					echo "<td>" . mysql_field_name($_res,$_i) . "</td>";
				}														
				echo "</tr>";
				// Agora o resultado
				while($_row=mysql_fetch_assoc($_res)) {
					$_t = mysql_fetch_lengths($_res);
					echo "<tr>";	
					$_i=0;
				 	foreach($_row as $_k=>$_vlr) {
						echo "<td>$_vlr ({$_t[$_i]})</td>";
						$_i++;
					}
					echo "</tr>";
				}
				echo "</table>";
			}
		}																			  
		
		mysql_close($_con);
		
	?>
