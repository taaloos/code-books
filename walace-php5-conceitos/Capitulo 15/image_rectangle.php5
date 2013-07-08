<?php
		header("Content-type: image/png");
	$_img = imagecreatetruecolor(300,300);
	$_w = imagesx($_img);
	$_h = imagesy($_img);
	$_b = imagecolorallocate($_img, 255,255,255);
	imagefilledrectangle($_img, 0,0,$_w,$_h, $_b);	
	for($_i=0;$_i<=128;$_i++) {
  		$_r = mt_rand(0,255);
  		$_g = mt_rand(0,255);
  		$_b = mt_rand(0,255);
  		$_c[$_i] = imagecolorallocate($_img, $_r,$_g,$_b);
	}			
	imagerectangle($_img, 0,0,$_w-1,$_h-1, $_c[5]);			  
	for($_i=0;$_i<=100;$_i++) {
  		$_px = mt_rand(0,$_w);
  		$_py = mt_rand(0,$_h);
		$_sx = mt_rand(5,70);
		$_sy = mt_rand(5,70);
  		$_x  = mt_rand(0,128);
		if($_i%2==0) {
			imagefilledrectangle($_img, $_px, $_py, $_x+$_sx, $_py+$_sy, $_c[$_x]);
		} else {
			imagerectangle(	$_img,$_px,$_py,$_x+$_sx, $_py+$_sy, $_c[$_x]);
		}
	}
	imagepng($_img);
?>
