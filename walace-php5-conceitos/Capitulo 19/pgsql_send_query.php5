	<?php
	
		$_con = pg_connect("host=localhost dbname=BD_PHP5 user=usuario password=senha");  

	
		$_sql  = "DELETE FROM Usuario WHERE userID = 5;";
		$_sql .= "UPDATE Usuario SET userNivel=4 WHERE userNivel=3;";
		$_sql .= "SELECT * FROM Usuario";
		
		$_cont = 0;
		while (pg_connection_busy($_con)) {
		  	$_cont++;	  
		  	sleep(5);
		  	if($_cont>10) {
		  		echo "Não é possivel enviar as consultas ao Servidor...";
				exit;
			}
		}
	
	
		// Enviar as consultas 	
		$_res = pg_send_query($_con,$_sql);
		if($_res===FALSE) {
			echo "Erro no envio das Consultas.. <br/>";
		} else {							   
			$_cr = 1;
			while($_res=pg_get_result($_con)) {
			   	if($_cr<=2) {
			   		echo "Registros afetados..." . pg_affected_rows($_res) . "<br>";
				} else {
					// SELECT...
					$_nr = pg_num_rows($_res);
					echo "A consulta retornou " . (int) $_nr . " registro(s)<br/>";
					if($_nr>0) {
						// Primeiro o cabeçalho com os campos da tabela
						echo "<table border=1 cellspacing=3>";
						echo "<tr bgcolor='#f0f0f0'>";
						for($_i=0;$_i<pg_num_fields($_res);$_i++) {
							echo "<td>" . pg_field_name($_res,$_i) . "</td>";
						}														
						echo "</tr>";
						// Agora o resultado
						while($_row=pg_fetch_assoc($_res)) {
							echo "<tr>";
						 	foreach($_row as $_vlr) {
								echo "<td>$_vlr</td>";
							}
							echo "</tr>";
						}
						echo "</table>";
					}
				}
				$_cr++;
			}
		}																			  
		
		
		pg_close($_con);
	?>