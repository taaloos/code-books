<?php
	echo "Tamanho atual: " . filesize("logo_php.gif");
	$_d = fopen("logo_php.gif","wb+");
	ftruncate($_d,512);
	fclose($_d);
	echo "....Novo Tamanho : " . filesize("logo_php.gif");
?>
