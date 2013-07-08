<?php
   	$_img = imagecreate(300,200);
   	$_prt = imagecolorallocate($_img, 0,0,0); 
	$_brc = imagecolorallocate($_img, 0xFF,0xFF,0xFF);
	$_vrm = imagecolorallocate($_img, 255,0,0); 
	imagefilledrectangle($_img,0,0,299,199,$_brc);
	imagerectangle($_img,0,0,299,199,$_prt);
	$_texto = "PHP 5 - " . date("d-m-Y H:i:s");
	$_font = "C:\WINDOWS\FONTS\arial.ttf";
	imagettftext($_img,15,35,50,190,$_vrm,$_font,$_texto);
   	header("Content-type: image/png");
	imagepng($_img);		 
?> 
