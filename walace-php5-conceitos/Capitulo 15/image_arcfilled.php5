<?php
  	function grafico_pizza($img,$_mc,$_vlr,$_cx,$_cy,$_dx=250,$_dy=125) {
		global $_cores;
		$rs = $_vlr;
	  	foreach($rs as $k=>$v) {
			if($v<0) {
				$rs[$k]=0;
			}
		}
		$total = array_sum($rs);
		$prim = 4;							 
		$_cy-=110;
		/* desenha uma série de arcos para formar a sombra do gráfico */
		for ($i = 110; $i > 90; $i--) {
		   	$ang = 45;
		   	$cor = 1;
		   	foreach($rs as $key=>$vlr) {
		  		$chv = (int) substr($key,2);
		  		$ang_final = $ang + ($vlr / $total) * 360;
		   		imagefilledarc($img,$_cx, $_cy+$i,$_dx, $_dy,$ang,$ang_final,$_cores["cor" . $cor . "D"],IMG_ARC_PIE);
		  		$ang = $ang_final;
		  		$cor++;
		   	}
		}
			  
		$ang = 45;
		$cor = 1;

		/* Desenha o gráfico de pizza */
		foreach($rs as $key=>$vlr) {
			$chv = (int) substr($key,2);
			$ang_final = $ang + ($vlr / $total) * 360;
			imagefilledarc($img,$_cx, $_cy+$i,$_dx, $_dy,$ang,$ang_final,$_cores["cor{$cor}"],IMG_ARC_PIE);
			$ang = $ang_final;
	     	$cor++;
		  }
	}
	
	
	function aloca_cor($_cor,$_nome) {
	   global $img, $_cores;
	   $_cores[$_nome] = imagecolorallocate($img, $_cor[0], $_cor[1], $_cor[2]); 
	}	


	// Exemplo de um gráfico 
	$img = imagecreatetruecolor(400, 400);
	$maximo_cores = 14;

	aloca_cor(Array(255, 255, 255),"branco");
	aloca_cor(Array(0x00,0x80,0xFF),"cor1");
	aloca_cor(Array(0x00,0x4E,0x9B),"cor1D");
	aloca_cor(Array(0xF9,0xF9,0x01),"cor6");
	aloca_cor(Array(0xCB,0xB1,0x01),"cor6D");
	aloca_cor(Array(0x3D,0xEB,0x0A),"cor3");
	aloca_cor(Array(0x18,0xAA,0x09),"cor3D");
	aloca_cor(Array(0xFF,0x00,0x00),"cor4");
	aloca_cor(Array(0x90,0x00,0x00),"cor4D");
	aloca_cor(Array(0x00,0xFF,0xFF),"cor5");
	aloca_cor(Array(0x00,0x82,0x82),"cor5D");
	aloca_cor(Array(0xC0,0xC9,0xC3),"cor2");
	aloca_cor(Array(0x90,0x90,0x90),"cor2D");
	aloca_cor(Array(0x80,0x00,0xFF),"cor7");
	aloca_cor(Array(0x40,0x00,0x80),"cor7D");
	aloca_cor(Array(0x00,0x00,0x80),"cor8");
	aloca_cor(Array(0x00,0x00,0x50),"cor8D");
	aloca_cor(Array(0x80,0x40,0x00),"cor9");
	aloca_cor(Array(0x5B,0x2E,0x00),"cor9D");
	aloca_cor(Array(0xFF,0x80,0x40),"cor10"); 
	aloca_cor(Array(0xAE,0x38,0x00),"cor10D");
	aloca_cor(Array(0x80,0x80,0x00),"cor11"); 
	aloca_cor(Array(0x51,0x51,0x00),"cor11D");
	aloca_cor(Array(0xFF,0x00,0x80),"cor12");
	aloca_cor(Array(0x80,0x00,0x40),"cor12D");
	aloca_cor(Array(0x00,0x80,0x00),"cor13");
	aloca_cor(Array(0x00,0x42,0x00),"cor13D");
	aloca_cor(Array(0xF5,0xCC,0x6B),"cor14");
	aloca_cor(Array(0xA9,0x87,0x21),"cor14D");
	aloca_cor(Array(236,233,216),"bg");

	imagefilledrectangle($img,0,0,400,400,$_cores["branco"]);

	for($_i=0;$_i<=5;$_i++) {
	   $_dados[] = mt_rand(50,1000);	
	}
	
	grafico_pizza($img,$maximo_cores,$_dados,199,199,300,200);
	
	header('Content-type: image/png');
	imagepng($img);
	imagedestroy($img);
?> 