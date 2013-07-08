<?php
// Gera uma imagem com o gradiente	  
function gradiente($_w=50,$_h=280,$_arq="gradiente.png") {
	$_img = imagecreatetruecolor($_w,$_h);
	$_prt = imagecolorallocate($_img, 0x00, 0x00, 0x00); 
	$_brc = imagecolorallocate($_img, 0xff, 0xff, 0xff);
	imagefilledrectangle($_img,0,0,$_w-1,$_h-1,$_brc);
	imagerectangle($_img,0,0,$_w-1,$_h-1,$_prt);

  	// Tabela de Cores
	$_idx_c = 0;
  	for($i=0;$i<=255;$i+=5) {
	  $_c["c_grad_". $_idx_c] = imagecolorallocate($_img,255,$i,0);
	  $_idx_c++;
    }
  	for($i=240;$i>=0;$i-=5) {
	  $_c["c_grad_". $_idx_c] = imagecolorallocate($_img,$i,255,0);
	  $_idx_c++;
    }
  	for($i=15;$i<=105;$i+=5) {
	  $_c["c_grad_". $_idx_c] = imagecolorallocate($_img,0,255,$i);
	  $_idx_c++;
    }
  	for($i=5;$i<=100;$i+=5) {
	  $_c["c_grad_". $_idx_c] = imagecolorallocate($_img,0,255-$i,135);
	  $_idx_c++;
    }

	// Desenha o gradiente....
	for($i=0;$i<=$_idx_c;$i++) {
		$_py1 = $_h-$i*2-2;
		$_py2 = $_h-($i+1)*2-2;
		$_cor = $_c["c_grad_". $i];
       	imagefilledrectangle($_img,1,$_py1 ,$_w-2,$_py2 ,$_cor);	
	}
	imagepng($_img,$_arq);
}

$_arq = "gradiente.png";
gradiente(50,280,$_arq);
?>
<img src="<?=$_arq;?>" border=0 alt="Gradiente">
