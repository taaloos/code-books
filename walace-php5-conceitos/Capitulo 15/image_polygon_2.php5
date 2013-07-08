<?php
	/*
		Desenha uma seta conforme os pontos indicados
		$_pontos = Array(x0,y0,x1,y1)
		$_c = Cor da linha
		$_p = Seta preenchida (TRUE) ou não (FALSE)
	*/ 
 	function flecha($_img,$_pontos,$_c,$_p=TRUE) {
	    $x = $_pontos[2];
	    $y = $_pontos[3];
	    $teta = atan2(($_pontos[3] - $_pontos[1]), ($_pontos[2] - $_pontos[0]));
	    $h = 20;
	    $b = 10;
	    $a = sqrt(pow($h,2)+pow($b,2));
	    $alfa = atan2($b,$h);
	    $pr[0] = $x;
	    $pr[1] = $y;
	    $pr[2] = $a * cos(deg2rad(180)+$teta+$alfa) + $x;
	    $pr[3] = $a * sin(deg2rad(180)+$teta+$alfa) + $y;
	    $pr[4] = $a * cos($teta-$alfa+deg2rad(180)) + $x;
	    $pr[5] = $a * sin($teta-$alfa+deg2rad(180)) + $y;
		imageline($_img, $_pontos[0],$_pontos[1],$_pontos[2],$_pontos[3],$_c);
		if($_p===TRUE) {
			imagefilledpolygon($_img,$pr,3,$_c);
		} else {
			imagefilledpolygon($_img,$pr,3,$_c);	
		}
  	}
	
	header("Content-type: image/png");
	$_img = imagecreatetruecolor(200,200);
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

	for($_i=20;$_i<=180;$_i=$_i+80) {
		flecha($_img,Array($_i,10,$_i,180),$_c[mt_rand(0,128)],TRUE);
		flecha($_img,Array($_i+40,180,$_i+40,20),$_c[mt_rand(0,128)],TRUE);	
	}
	
	imagepng($_img);
	imagedestroy($_img);
	 
	 
?>

