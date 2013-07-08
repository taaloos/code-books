<?php
	if($_GET["COOKIE"]=="S") {
	    print_r($_COOKIE);
		if($_COOKIE["cookie"]==1) {
			echo "OK.. Cookie habilitado..";
		}
		else {
			echo "Erro….Cookies não são permitidos neste computador.";
		}
	}
	else {
		setcookie("cookie",1);
		header("Location: " . $_SERVER["PHP_SELF"] . "?COOKIE=S");
	}
?>
