<?php
	class seta extends imagem {
		/*
		Desenha uma seta conforme os pontos indicados
		$_pontos = Array(x0,y0,x1,y1)
		$_c = Cor da linha
		$_p = Seta preenchida (TRUE) ou não (FALSE)
		*/ 	   
 		public function flecha($_pontos,$_c,$_p=TRUE) {
	    	$x = $_pontos[2];
    		$y = $_pontos[3];
	    	$teta = atan2(($_pontos[3] - $_pontos[1]),($_pontos[2] - $_pontos[0]));
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

			imageline( $this->_img, $_pontos[0], $_pontos[1], $_pontos[2], $_pontos[3], $this->_cores[$_c]);
			if($_p===TRUE) {
				imagefilledpolygon($this->_img,$pr,3,$this->_cores[$_c]);
			} else {
				imagefilledpolygon($this->_img,$pr,3,$this->_cores[$_c]);	
			}
	  	}
	}
?>