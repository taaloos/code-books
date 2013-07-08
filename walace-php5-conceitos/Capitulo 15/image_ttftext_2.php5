<?php
   	$_img = imagecreate(300,200);
   	$_prt = imagecolorallocate($_img, 0,0,0); 
	$_brc = imagecolorallocate($_img, 0xFF,0xFF,0xFF);
	$_vrm = imagecolorallocate($_img, 255,0,0); 
	imagefilledrectangle($_img,0,0,299,199,$_brc);
	// Primeiro na horizontal
	$_texto = " PHP 5   ";
	$_font = "C:\WINDOWS\FONTS\arial.ttf";
	imagettftext($_img,15,0,20,190,$_vrm,$_font,$_texto);
	$_coord = imagettfbbox(15,0,$_font,$_texto);					 
	imagestring($_img,3,10,10,"({$_coord[0]},{$_coord[1]});({$_coord[2]},{$_coord[3]})",$_prt);
	// traçar a linha com 2 pixels de espaço para o texto...
	imageline($_img,$_coord[0]+20,$_coord[1]+192,$_coord[2]+20,$_coord[3]+192,$_vrm);
	imageline($_img,$_coord[4]+20,$_coord[5]+187,$_coord[6]+20,$_coord[7]+187,$_vrm);

	// Agora na Vertical
	$_texto = date(" d-m-Y ");		   
	$_pos_x = $_coord[2]+20;
	$_coord_2 = imagettfbbox(15,0,$_font,$_texto);					 
	$_pos_x+= ($_coord_2[1]-$_coord_2[5])+5;
	$_coord_2 = imagettfbbox(15,90,$_font,$_texto);					 	
	imagettftext($_img,15,90,$_pos_x,190,$_vrm,$_font,$_texto);
	imagestring($_img,3,150,10,"({$_coord_2[0]},{$_coord_2[1]});({$_coord_2[4]},{$_coord_2[5]})",$_prt);
	// traçar a linha com 2 pixels de espaço para o texto...
	imageline($_img,$_coord_2[0]+$_pos_x+5,$_coord_2[1]+184,$_coord_2[2]+$_pos_x+5,$_coord_2[3]+187,$_vrm);
	imageline($_img,$_coord[4]+20,$_coord[5]+187,$_coord[4]+20,$_coord_2[5]+187,$_vrm);	
	imageline($_img,$_coord[2]+20,$_coord[3]+192,$_coord_2[0]+$_pos_x+5,$_coord_2[1]+184,$_vrm);
   	header("Content-type: image/png");
	imagepng($_img);		 
?> 
