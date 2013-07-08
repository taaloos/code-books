	<?php
		// Teste 1...
		$_POST["usuario"] = "walace";
		$_POST["senha"] = "Senha";
		
		$_con = @mysql_connect("localhost","root","");
		mysql_select_db("BD_PHP5",$_con);
		
		function anti_ataque($_sql) {
			if(get_magic_quotes_gpc()) {
				$_sql = stripslashes($_sql);
			}
			return mysql_real_escape_string($_sql);
		}

		echo "Teste 1...<br/>";
		
		$_sql = "SELECT * FROM Usuario WHERE ";
		$_sql.= "userLogin = '" . anti_ataque($_POST["usuario"]) . "' AND ";
		$_sql.= "userPassw = '" . anti_ataque($_POST["senha"]) . "'"; 
		$_res = mysql_query($_sql,$_con);
		if(mysql_num_rows($_res)>0) {
			$_r = mysql_fetch_assoc($_res);
			echo "Bem vindo {$_r["userName"]}";
		} else {
			echo "Usuário ou Senha Inválido...Tente novamente";
		}
		   
		echo "<br/><br/>Teste 2 com o ataque...<br/>";
		// Teste 2...
		$_POST["usuario"] = "jose_silva";
		$_POST["senha"] = "' OR '1'='1";
		
		$_sql = "SELECT * FROM Usuario WHERE ";
		$_sql.= "userLogin = '" . anti_ataque($_POST["usuario"]) . "' AND ";
		$_sql.= "userPassw = '" . anti_ataque($_POST["senha"]) . "'"; 
		$_res = mysql_query($_sql,$_con);  
		if(mysql_num_rows($_res)>0) {
			$_r = mysql_fetch_assoc($_res);
			echo "Bem vindo {$_r["userName"]}";
		} else {
			echo "Usuário ou Senha Inválido...Tente novamente";
		}
	?>
