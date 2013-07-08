<?php
		header("Content-type: image/png");
	$_img = imagecreatetruecolor(150, 150);
	$_cor = imagecolorallocate($_img, 204, 204, 204);
	$_cza = imagecolorallocate($_img, 0xbe, 0xb4, 0x9c);
	$_prt = imagecolorallocate($_img, 0, 0, 0); 
	$_brc = imagecolorallocate($_img, 255, 255, 255);
	imagefilledrectangle($_img,0,0,149,149,$_brc);
	imagefilledellipse($_img,75,75,130,110,$_cza);
	imagefilledellipse($_img,75,75,120,100,$_cor);
	imageellipse($_img,75,75,120,100,$_prt);
	imageellipse($_img,75,75,130,110,$_prt);
	imagepng($_img);
	imagedestroy($_img);
?>
