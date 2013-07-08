<?php
	$_con = new mysqli("localhost","root","","BD_PHP5");

	if (mysqli_connect_errno()) {
   		printf("Connect failed: %s\n", mysqli_connect_error());
	   exit();
	}

	printf("Host information: %s\n", $_con->host_info);
	
	$_res = $_con->query("SELECT * FROM Usuario");
	
	echo $_res->num_rows;
	
	$_con->close();		 
?>	