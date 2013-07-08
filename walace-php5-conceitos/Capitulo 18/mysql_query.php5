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
	
	// incluir alguns registros na tabela Usuario
	$_sql = "INSERT INTO Usuario VALUES";
	$_sql .= "(NULL,'Walace Soares','Walace','walace',5,'walace@walace.com.br'),";
	$_sql .= "(NULL,'Mara Soares','Mara','mara',3,'mara@walace.com.br'),";
	$_sql .= "(NULL,'Anna Carolina','Carol','carol',1,'carol@walace.com.br'),";	
	$_sql .= "(NULL,'Isabelle Soares','Isabelle','bel',1,'bel@walace.com.br')";	
	
	$_res = mysql_query($_sql,$_con);
	if($_res===FALSE) {
		echo "Erro na inclusão dos registros... " . mysql_error() . "<br/>";
	} else {
		echo mysql_affected_rows($_con) . " Registros incluidos com Sucesso<br/>";
	}																			  
	
	// Agora vamos alterar alguns registros
	$_sql = "UPDATE Usuario SET userNivel=2 WHERE userNivel=1";
	$_res = mysql_query($_sql,$_con);
	if($_res===FALSE) {
		echo "Erro na alteração dos registros... " . mysql_error() . "<br/>";
	} else {
		echo mysql_affected_rows($_con) . " Registros alterados<br/>";
	}																			  
	
	// finalmente vamos listar os registros existentes no Banco
	$_sql = "SELECT * FROM Usuario";
	$_res = mysql_query($_sql,$_con);
	if($_res===FALSE) {
		echo "Erro na consulta... " . mysql_error() . "<br/>";
	} else {				  
		$_nr = mysql_num_rows($_res);
		echo "A consulta retornou " . (int) $_nr . " registro(s)<br/>";
		if($_nr>0) {
			// Primeiro o cabeçalho com os campos da tabela
			echo "<table border=1 cellspacing=3>";
			echo "<tr bgcolor='#f0f0f0'>";
			for($_i=0;$_i<mysql_num_fields($_res);$_i++) {
				echo "<td>" . mysql_field_name($_res,$_i) . "</td>";
			}														
			echo "</tr>";
			// Agora o resultado
			while($_row=mysql_fetch_assoc($_res)) {
				echo "<tr>";
			 	foreach($_row as $_vlr) {
					echo "<td>$_vlr</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
		}
	}																			  
	
	mysql_close($_con);
	
?>
