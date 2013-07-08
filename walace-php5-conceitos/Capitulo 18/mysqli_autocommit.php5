	<?php
		$_con  = new mysqli("localhost","root","","BD_PHP5");
		if(!$_con) {  
		// ou if(mysqli_connect_errno()!=0) {
			echo "Não foi possivel conectar ao MySQL. Erro #" .
					mysqli_connect_errno() . " : " . mysql_connect_error();
			exit;
		}
		

		$_con->autocommit(FALSE);
		
		// Criar uma tabela nova no MySQL do tipo InnoDB
		$_sql = "CREATE TABLE Usrbck LIKE Usuario";
		$_con->query($_sql);
		if($_con->errno!=0) {
			echo "Erro ao criar a tabela..." . $_con->error;
			exit;
		}		 
		
		// Altera o tipo da tabela
		$_sql = "ALTER TABLE Usrbck Type=InnoDB";
		$_con->query($_sql);		
		
		$_con->commit();
		
		// Incluir alguns registros
		$_sql = "INSERT INTO Usrbck SELECT * FROM Usuario ";
		$_sql.= "WHERE UserNivel=2";
		$_con->query($_sql);
		if($_con->errno!=0) {
			echo "Erro ao inserir registros na tabela..." . $_con->error;
			exit;
		} else {
			echo "Foram incluidos " . $_con->affected_rows . " Registros<br/>";
		}
		
		$_con->commit();
		
		// Função para listar uma tabela qualquer
		function listar($_con,$_tabela) {
			$_sql = "SELECT * FROM $_tabela";
			$_res = $_con->query($_sql);
			if($_res===FALSE) {
				echo "Erro na consulta... " . $_con->error . "<br/>";
			} else {				  
				$_nr = $_res->num_rows;
				echo "A consulta retornou " . (int) $_nr . " registro(s)<br/>";
				if($_nr>0) {
					// Primeiro o cabeçalho com os campos da tabela
					echo "<table border=1>";
					echo "<tr bgcolor='#f0f0f0'>";
					for($_i=0;$_i<$_res->field_count;$_i++) {
						$_f = $_res->fetch_field_direct($_i);
						echo "<td>" . $_f->name . "</td>";
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
				$_res->close();
			}																			  
		}		
		
		// Listar a tabela.. situação após INSERT
		listar($_con,"Usrbck");

		// Excluir		
		$_sql = "DELETE FROM Usrbck WHERE userId>=6";
		$_con->query($_sql);
		if($_con->errno!=0) {
			echo "Erro ao Excluir registros na tabela..." . $_con->error;
			exit;
		} else {
			echo "Foram Excluidos " . $_con->affected_rows . " Registros<br/>";
		}
		
		
		// Lista Novamente
		listar($_con,"Usrbck");
		
		// Desfazer a exclusão
		$_con->rollback();
		
		// Listar a tabela...
		listar($_con,"Usrbck");
		
		// Finalmente excluir a tabela 
		$_sql = "DROP TABLE Usrbck";
		$_con->query($_sql);
		$_con->commit();
		
		$_con->close();
	?>
