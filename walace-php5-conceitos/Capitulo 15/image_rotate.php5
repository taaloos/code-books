<?php
	$_img = imagecreatefromjpeg("chess03.jpg");
	$_c = imagecolorallocate($_img,255,255,255);
	$_img_2 = imagerotate($_img,180,$_c);
	imagejpeg($_img_2,"chess04.jpg");		 
	imagedestroy($_img);
?>				   
<img src="chess03.jpg" border=0><br/>
<img src="chess04.jpg" border=0>

