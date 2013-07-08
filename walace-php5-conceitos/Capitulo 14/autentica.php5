<?php
 	if (!isset($_SERVER['PHP_AUTH_USER'])) {
  		header('WWW-Authenticate: Basic realm="PHP5"');
  		header('HTTP/1.0 401 Não Autorizado');
  		echo '<font color="red"><b>Página de acesso Restrito, pressione F5...</b></font>';
  		exit;
 	} else {
  		echo "<p><b>Olá {$_SERVER['PHP_AUTH_USER']}</b>.</p>";
  			echo "<p>Senha Digitada: <b>{$_SERVER['PHP_AUTH_PW']}</b></p>";
 	}
?>
