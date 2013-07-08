<?php

	$_con = pg_connect("host=localhost dbname=BD_PHP5 user=usuario password=senha");  

/*	$_sql  = "INSERT INTO Usuario VALUES";
	$_sql2 = "(DEFAULT,'Walace Soares','Walace','walace',5,'walace@walace.com.br')";

	$_res = pg_query($_con,$_sql . $_sql2);
	if($_res) $_cont++;

	$_sql2 = "(DEFAULT,'Mara Soares','Mara','mara',3,'mara@walace.com.br')";
	$_res = pg_query($_con,$_sql . $_sql2);
	if($_res) $_cont++;

	$_sql2 = "(DEFAULT,'Anna Carolina','Carol','carol',1,'carol@walace.com.br')";	
	$_res = pg_query($_con,$_sql . $_sql2);
	if($_res) $_cont++;

	$_sql2 = "(DEFAULT,'Isabelle Soares','Isabelle','bel',1,'bel@walace.com.br')";	
	$_res = pg_query($_con,$_sql . $_sql2);
	if($_res) $_cont++;
	
	echo "Total de Registros incluidos: $_cont";
*/

	// Agora vamos alterar alguns registros
	$_sql = "UPDATE Usuario SET userNivel=2 WHERE userNivel=1";
	$_res = pg_query($_con,$_sql);
	if($_res===FALSE) {
		echo "Erro na alteração dos registros...<br/>";
	} else {
		echo pg_affected_rows($_res) . " Registros alterados<br/>";
	}																			  
	
	// finalmente vamos listar os registros existentes no Banco
	$_sql = "SELECT * FROM Usuario";
	$_res = pg_query($_con,$_sql);
	if($_res===FALSE) {
		echo "Erro na consulta... " . pg_result_error($_res) . "<br/>";
	} else {				  
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
	
	
	pg_close($_con);
?>