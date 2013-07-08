	<?php
	
		$_con = pg_connect("host=localhost dbname=BD_PHP5 user=usuario password=senha");  

	
	
		// Iniciar a Transação
		$_sql = "BEGIN";
		pg_query($_sql);		
		
		// Criar uma tabela nova
		$_sql = "SELECT * INTO Usrbck FROM Usuario WHERE ";
		$_sql.= "UserNivel=2";
		$_res = pg_query($_con,$_sql);
		if(pg_result_error($_res)!="") {
			echo "Erro ao criar a tabela..." . pg_result_error($_res);
			exit;
		}		 
		
		
		// efetuar alterações
		echo "COMIT na criação da tabela...<br/>";
		$_sql = "COMMIT";
		pg_query($_con,$_sql);
		
		// Nova transação
		$_sql = "BEGIN";
		pg_query($_sql);	
			
		// Função para listar uma tabela qualquer
		function listar($_con,$_tabela) {
			$_sql = "SELECT * FROM $_tabela";
			$_res = pg_query($_con,$_sql);
			if($_res===FALSE) {
				echo "Erro na consulta...<br/>";
			} else {				  
				$_nr = pg_num_rows($_res);
				echo "A consulta retornou " . (int) $_nr . " registro(s)<br/>";
				if($_nr>0) {
					// Primeiro o cabeçalho com os campos da tabela
					echo "<table border=1>";
					echo "<tr bgcolor='#f0f0f0'>";
					for($_i=0;$_i<pg_num_fields($_res);$_i++) {
						$_f = pg_field_name($_res,$_i);
						echo "<td>$_f</td>";
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
				pg_free_result($_res);
			}																			  
		}		
		
		// Listar a tabela.. situação após INSERT
		listar($_con,"Usrbck");

		// Excluir		
		$_sql = "DELETE FROM Usrbck WHERE userId>=6";
		$_res = pg_query($_con,$_sql);
		if($_res===FALSE) {
			echo "Erro ao Excluir registros na tabela...";
			exit;
		} else {
			echo "Foram Excluidos " . pg_affected_rows($_res) . " Registros<br/>";
		}
		
		
		// Lista Novamente
		listar($_con,"Usrbck");
		
		// Desfazer a exclusão
		echo "ROLBACK após a exclusão..<br/>";
		$_sql = "ROLLBACK";
		pg_query($_con,$_sql);
		
		// Listar a tabela...
		listar($_con,"Usrbck");
		
		// Finalmente excluir a tabela 
		$_sql = "DROP TABLE Usrbck";
		pg_query($_con,$_sql);
		echo "Tabela Excluida..<br/>";
									 
		
		pg_close($_con);
	?>