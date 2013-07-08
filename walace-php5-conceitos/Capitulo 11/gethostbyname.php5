<?php
	$_host = "www.zanthus.com.br";
	$_t1 = microtime();
	$_ip = gethostbyname($_host);
	$_t2 = microtime();
	echo $_ip . " Tempo de busca: " . ($_t2-$_t1);
	echo "<br/>";
	$_t1 = microtime();
	$_host = gethostbyaddr("64.246.30.37");
	$_ip = gethostbyname($_host);
	echo " $_host  [$_ip ]  Tempo de busca: " . ( microtime()-$_t1);
?>
