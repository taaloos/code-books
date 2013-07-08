<?php
	session_start(); 
	define('MAXIMO_CONT',99);
	if(isset($_SESSION["CONTADOR"])) {
		if($_SESSION["CONTADOR"]==MAXIMO_CONT) {
			unset($_SESSION["CONTADOR"]);
		}
	}
	if(!isset($_SESSION["CONTADOR"])) {
		$_SESSION["CONTADOR"]=0;
	}
	$_SESSION["CONTADOR"]++;
	echo "<b><big>{$_SESSION["CONTADOR"]}</big></b>";
?>
