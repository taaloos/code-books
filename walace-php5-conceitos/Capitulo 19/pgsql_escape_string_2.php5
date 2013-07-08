	<?php
	
		$_con = pg_connect("host=localhost dbname=BD_PHP5 user=usuario password=senha");  
		

		function anti_ataque($_sql) {
			if(get_magic_quotes_gpc()) {
				$_sql = stripslashes($_sql);
			}
			return pg_escape_string($_sql);
		} 
		
		
		// primeiro teste 
		$_POST["login"] = "Jose";
		$_POST["senha"] = "1234";
	
		$_sql = "SELECT * FROM Usuario WHERE ";
		$_sql.= "userLogin= '" . anti_ataque($_POST["login"]) . "' AND ";
		$_sql.= "userPassw = '" . anti_ataque($_POST["senha"]) . "'";
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
		$_sql.= "userLogin= '" . anti_ataque($_POST["login"]) . "' AND ";
		$_sql.= "userPassw = '" . anti_ataque($_POST["senha"]) . "'";
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
		$_sql.= "userLogin= '" . anti_ataque($_POST["login"]) . "' AND ";
		$_sql.= "userPassw = '" . anti_ataque($_POST["senha"]) . "'";
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