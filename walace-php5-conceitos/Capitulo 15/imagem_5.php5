<?php
 	header("Content-type: image/png");
	$_img = imagecreatetruecolor(150, 150);			  
	for($_i=0;$_i<=128;$_i++) {
	  $_r = mt_rand(0,255);
	  $_g = mt_rand(0,255);
	  $_b = mt_rand(0,255);
	  $_c[$_i] = imagecolorallocate($_img, $_r,$_g,$_b);
	}					  
	$_x  = mt_rand(0,128);
	imagefilledrectangle($_img,0,0,149,149,$_c[$_x]);
	for($_i=0;$_i<=1024;$_i++) {
	  $_px = mt_rand(0,149);
	  $_py = mt_rand(0,149);
	  $_x  = mt_rand(0,128);
	  imagesetpixel($_img,$_px,$_py,$_c[$_x]);
	}
	imagepng($_img);
?> 
