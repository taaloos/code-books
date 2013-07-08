<?php
  	$_img = imagecreate(300,200);
   	$_prt = imagecolorallocate($_img, 0,0,0); 
	$_brc = imagecolorallocate($_img, 0xFF,0xFF,0xFF);
	$_vrm = imagecolorallocate($_img, 255,0,0); 
	imagefilledrectangle($_img,0,0,299,199,$_brc);
	$_img_fnt = imagecreatefromJpeg("Bola.jpg");
	$_w = imagesx($_img_fnt);
	$_h = imagesy($_img_fnt);
	for($i=0;$i<=512;$i++) {
		$_dx = mt_rand(2,20);
		$_dy = mt_rand(2,20);
		$_px = mt_rand(0,$_w);
		$_py = mt_rand(0,$_h);
		$_fx = mt_rand(0,300);
		$_fy =  mt_rand(0,200);
		imagecopy($_img,$_img_fnt,$_px,$_py,$_fx,$_fy,$_dx,$_dy);
	}
   	header("Content-type: image/png");
	imagepng($_img);		 
	imagedestroy($img);
	imagedestroy($img_fnt);
?>	

