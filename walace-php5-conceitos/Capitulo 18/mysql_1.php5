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
	
	$_sql = "DESCRIBE Usuario";
	$_res = mysql_query($_sql,$_con);
	while($_row = mysql_fetch_array($_res,MYSQL_ASSOC)) {
	 foreach($_row as $_k=>$_vlr) {	
	 	echo "$_k = $_vlr ;&nbsp;&nbsp;";
	 }									 
	 echo "<br/>";
	}
	
?>
