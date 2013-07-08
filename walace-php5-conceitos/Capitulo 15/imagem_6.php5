<?php
 	header("Content-type: image/png");
	$_img = imagecreatetruecolor(151, 151);
	$_cor = imagecolorallocate($_img, 0x33, 0x00, 0xff);
	$_prt = imagecolorallocate($_img, 0x00, 0x00, 0x00); 
	$_brc = imagecolorallocate($_img, 0xff, 0xff, 0xff);
	imagefilledrectangle($_img,0,0,150,150,$_brc);		
	
	// desenha a grade...
	for($_i=0;$_i<151;$_i=$_i+15) {
	  imageline($_img,$_i,0,$_i,149,$_cor);
	  imageline($_img,0,$_i,149,$_i,$_cor);
	}
	imagepng($_img);
?> 
