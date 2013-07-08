<?php
 	header("Content-type: image/png");
	$_img = imagecreatetruecolor(150, 150);
	$_cor = imagecolorallocate($_img, 0x33, 0x00, 0xff);
	$_prt = imagecolorallocate($_img, 0x00, 0x00, 0x00); 
	$_brc = imagecolorallocate($_img, 0xff, 0xff, 0xff);
	imagefilledrectangle($_img,0,0,149,149,$_brc);
	imagefilledellipse($_img,75,75,100,100,$_cor);
	imageellipse($_img,75,75,105,105,$_prt);
	imagestring($_img, 5, 58, 67, "PHP5", $_brc);
	imagepng($_img);
?> 
