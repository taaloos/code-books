<?php
	include("class_imagem.inc");
	include("class_seta.inc");
	$_s = new seta();
	$_s->novaImagem(400,300);
	$_s->alocaCor("branco",Array(255,255,255));
	$_s->alocaCor("Azul",Array(0,0,255));
	imagefilledrectangle($_s->_img,0,0,399,299,$_s->getCor("branco"));
	$_s->flecha(Array(30,150,350,150),"Azul",TRUE);
	$_s->mostra();
	$_s->destroi();
?>
