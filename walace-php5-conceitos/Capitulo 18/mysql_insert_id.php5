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
		$_sql .= "(NULL,'Rogério Alegruci','Rogério','rogerio',2,'rogerio@walace.com.br')";
		
		$_res = mysql_query($_sql,$_con);
		if($_res===FALSE) {
			echo "Erro na inclusão dos registros... " . mysql_error() . "<br/>";
		} else {
			echo mysql_affected_rows($_con) . " Registros incluidos com Sucesso<br/>";
		}																			  
		
		// LAST_ID
		$_sql = "SELECT LAST_INSERT_ID()";
		$_res = mysql_query($_sql,$_con);
		$_id = mysql_fetch_row($_res);
		echo "SELECT LAST_INSERT_ID() Retornou: $_id[0] <br/>";
		
		// mysql_insert_id
		$_id2 = mysql_insert_id($_con);
		echo "mysql_insert_id Retornou: $_id2 <br/>";	
		
		mysql_close($_con);
		
	?>
