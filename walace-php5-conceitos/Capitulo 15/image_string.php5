<?php
   	$_img = imagecreate(300,200);
   	$_prt = imagecolorallocate($_img, 0,0,0); 
	$_brc = imagecolorallocate($_img, 0xFF,0xFF,0xFF);
	$_vrm = imagecolorallocate($_img, 255,0,0); 
	imagefilledrectangle($_img,0,0,299,199,$_brc);
	imagerectangle($_img,0,0,299,199,$_prt);
	$_texto = "PHP 5 - " . date("d-m-Y H:i:s");
	for($_i=1;$_i<=5;$_i++) {
		imagestring($_img,$_i,5,$_i*20,"Fonte $_i : {$_texto}",$_vrm);
	}
	$_f = imageloadfont("betsy.gdf");
	imagestring($_img,$_f,5,150,"PHP 5",$_prt);
   	header("Content-type: image/png");
	imagepng($_img);		 
?> 
				