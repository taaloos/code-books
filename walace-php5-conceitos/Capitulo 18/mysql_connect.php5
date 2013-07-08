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
?>
