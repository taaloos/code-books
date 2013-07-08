<?php
   	$_img = imagecreate(150,100);
   	$_prt = imagecolorallocate($_img, 0,0,0); 
	$_verde = imagecolorallocate($_img, 0x33,0xFF,0x33);
	$_vrm = imagecolorallocate($_img, 255,0,0); 
	imagefilledrectangle($_img,0,0,149,99,$_verde);
	imagerectangle($_img,0,0,149,99,$_prt);
	imagerectangle($_img,3,3,15,15,$_vrm);
	imageline($_img,4,4,14,14,$_vrm);
	imageline($_img,4,14,14,4,$_vrm);
	imagestring($_img,5,50,40,"TESTE",$_vrm);
	imagestring($_img,5,15,60,"TRANSPARENCIA",$_vrm);				
	imagecolortransparent($_img,$_verde);
   	header("Content-type: image/png");
	imagepng($_img);		 
?> 
				