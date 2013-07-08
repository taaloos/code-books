<?php
	session_start(); 
	if(!isset($_SESSION["CONTADOR"])) {
		$_SESSION["CONTADOR"]=0;
	}
	elseif($_SESSION["CONTADOR"]>=99) {
	  unset($_SESSION["CONTADOR"]);
	}
	$_SESSION["CONTADOR"]++;
	echo "<b><big>{$_SESSION["CONTADOR"]}</big></b>"; 
?>
