<?php
	$_str = "http://www.erica.com.br";
	echo ereg_replace("http://www", "ftp://ftp", $_str);
	echo "<br/>";
	echo ereg_replace("(http):", "\\1s:", $_str);
	echo "<br/>";
	echo ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]",
                     "<a href=\"\\0\">\\0</a>", $_str);
	echo "<br/>";
	$_l=ereg_replace("(([^\.<>[:space:]]+\.)|([[:alpha:]]+://))+". "[^\.<>[:space:]]+\.[^<>[:space:]]+", "<a href=\"http://\\0\" target=\"_blank\">\\0</a>", $_str);
	$_l=ereg_replace("http://([[:alpha:]]+://)","\\1",$_str); 
	echo $_l;					 
?> 	
