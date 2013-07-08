	<?php
	
		$_con = pg_connect("host=localhost dbname=BD_PHP5 user=usuario password=senha");  

		
		// primeiro teste 
		$_POST["login"] = "Jose";
		$_POST["senha"] = "1234";
	
		$_sql = "SELECT * FROM Usuario WHERE ";
		$_sql.= "userLogin= '{$_POST["login"]}' AND ";
		$_sql.= "userPassw = '{$_POST["senha"]}'";
		$_res = pg_query($_con,$_sql);
		if($_res===FALSE||pg_num_rows($_res)<=0) {
			echo "Login/Senha inválidos..<br/>";
		} else {
			$_d = pg_fetch_assoc($_res);
			echo "Olá, " . $_d["username"];
		}																			  


		// Segundo teste
		$_POST["login"] = "Walace";
		$_POST["senha"] = "walace";			   
		
		$_sql = "SELECT * FROM Usuario WHERE ";
		$_sql.= "userLogin= '{$_POST["login"]}' AND ";
		$_sql.= "userPassw = '{$_POST["senha"]}'";
		$_res = pg_query($_con,$_sql);
		if($_res===FALSE||pg_num_rows($_res)<=0) {
			echo "Login/Senha inválidos..<br/>";
		} else {
			$_d = pg_fetch_assoc($_res);
			echo "Olá, " . $_d["username"];
			echo "<br/>";
		}																			  
	
		// terceiro teste..
		$_POST["login"] = "Jose";
		$_POST["senha"] = "' OR '1'='1";

		$_sql = "SELECT * FROM Usuario WHERE ";
		$_sql.= "userLogin= '{$_POST["login"]}' AND ";
		$_sql.= "userPassw = '{$_POST["senha"]}'";
		echo "$_sql<br/>";
		$_res = pg_query($_con,$_sql);
		if($_res===FALSE||pg_num_rows($_res)<=0) {
			echo "Login/Senha inválidos..<br/>";
		} else {
			$_d = pg_fetch_assoc($_res);
			echo "Olá, " . $_d["username"];
		}																			  



		pg_close($_con);
	?>