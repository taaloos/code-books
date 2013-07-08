	<?php
		$_con  = new mysqli("localhost","root","","BD_PHP5");
		if(!$_con) {  
			echo "Não foi possivel conectar ao MySQL. Erro #" .
					mysqli_connect_errno() . " : " . mysql_connect_error();
			exit;
		}
		
		function anti_ataque($_sql,$_con) {
			if(get_magic_quotes_gpc()) {
				$_sql = stripslashes($_sql);
			}
			return $_con->real_escape_string($_sql);
		} 
		
		$_sql = "SELECT * FROM Usuario WHERE ";
		$_sql.= "userLogin = '" . anti_ataque($_POST["usuario"],$_con) . "' AND ";
		$_sql.= "userPassw = '" . anti_ataque($_POST["senha"],$_con) . "'"; 
		$_res = $_con->query($_sql);
		if($_res->num_rows>0) {
			$_r = $_res->fetch_assoc();
			echo "Bem vindo {$_r["userName"]}";
		} else {
			echo "Usuário ou Senha Inválido...Tente novamente";
		}
	?>
