<?php
	session_start();
 	if($_GET["INICIAR"]=="S") {
		session_unset();
		session_destroy();
		echo "<script>document.location.href='{$_SERVER["PHP_SELF"]}';</script>";
	}
	if(!isset($_SESSION["CONTADOR"])) {
		$_SESSION["CONTADOR"]=0;
	}
	$_SESSION["CONTADOR"]++;
	echo "Contador Atual: ";
	echo "<b><big>{$_SESSION["CONTADOR"]}</big></b>";
	echo "&nbsp;&nbsp;<a href='{$_SERVER["PHP_SELF"]}?INICIAR=S'>ReIniciar Contagem</a>";
?>
