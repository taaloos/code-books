<?php
	header("Content-type: image/png");
	$_img = imagecreatetruecolor(500,500);
	$_w = imagesx($_img);
	$_h = imagesy($_img);
	$_b = imagecolorallocate($_img, 255,255,255);
	$_c = imagecolorallocate($_img, 0x00, 0x40, 0x80);
	imagefilledrectangle($_img, 0,0,$_w,$_h, $_b);	
	imagerectangle($_img, 150,150, 350, 350, $_c);		
	for($_i=20;$_i<=200;$_i=$_i+20) {
		imagearc($_img, 150, 250, $_i, $_i, 90, 270, $_c);
		imagearc($_img, 350, 250, $_i, $_i, 270, 90, $_c);
		imagearc($_img, 250, 150, $_i, $_i, 180, 360, $_c);
		imagearc($_img, 250, 350, $_i, $_i, 0, 180, $_c);
	}
	imagepng($_img);
	imagedestroy($_img);
?>

