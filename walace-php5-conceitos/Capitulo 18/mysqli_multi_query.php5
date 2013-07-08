	<?php
		$_con  = new mysqli("localhost","root","","BD_PHP5");
		if(!$_con) {  
		// ou if(mysqli_connect_errno()!=0) {
			echo "Não foi possivel conectar ao MySQL. Erro #" .
					mysqli_connect_errno() . " : " . mysql_connect_error();
			exit;
		}
		
		// incluir alguns registros na tabela Usuario
		$_sql = "DELETE FROM Usuario WHERE userID = 5;";
		$_sql= "UPDATE Usuario SET userNivel=4 WHERE userNivel=3;";
		$_sql.= "SELECT * FROM Usuario";
		if(!$_con->multi_query($_sql)) {
			echo "Erro na consulta... " . $_con->error . "<br/>";
		} else {				  
			$_af = $_con->affected_rows;
			echo "Número de registros afetados... $_af <br/>";
			do {			
				if($_res = $_con->store_result()) {
				 	// Temos um resultado
					$_nr = $_res->num_rows;
					echo "A consulta retornou " . (int) $_nr . " registro(s)<br/>";
					if($_nr>0) {
						// Primeiro o cabeçalho com os campos da tabela
						echo "<table border=1>";
						echo "<tr bgcolor='#f0f0f0'>";
						for($_i=0;$_i<$_res->field_count;$_i++) {
							$_f = $_res->fetch_field_direct($_i);
							echo "<td> " . $_f->name . "</td>";
						}														
						echo "</tr>";
						// Agora o resultado
						while($_row=$_res->fetch_assoc()) {
							echo "<tr>";
				 			foreach($_row as $_vlr) {
								echo "<td>$_vlr</td>";
							}
							echo "</tr>";
						}
						echo "</table>";
					}
				}
				if($_con->more_results()) {
						echo "<br/>";
				}
			} while ($_con->next_result());
		}																			  
	
		$_con->close();
	?>
