<?php
	header("Content-type: image/png");
	$_img = imagecreatetruecolor(500,500);
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
	$_num_pontos = mt_rand(10,5000);
	for($_i=0;$_i<$_num_pontos;$_i++) {
		$_pontos[] = mt_rand(5,$_w-5);
		$_pontos[] = mt_rand(5,$_h-5);
	}
	$_x  = mt_rand(0,128);
	if($_i%2==0) {
		imagefilledpolygon($_img, $_pontos,$_num_pontos, $_c[$_x]);
	} else {
		imagepolygon($_img, $_pontos,$_num_pontos, $_c[$_x]);
	}
	imagepng($_img);
	imagedestroy($_img);
?>

