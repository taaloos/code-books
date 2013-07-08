<?php
	$_str = "<P><B>TESTE de file_put_contents()</B></P>";
	file_put_contents("teste.php5",$_str);
	$_str = "<P>Data: <?=date(\"d-m-Y H:i:s\")?></P>";
	file_put_contents("teste.php5",$_str,FILE_APPEND);
	echo htmlentities(file_get_contents("teste.php5"));
	include_once("teste.php5");
?>
