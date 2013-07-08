<?php
	function rgb2hex($rgb){
  		for($i=0;$i<count($rgb);$i++){
      		if(strlen($hex[$i] = dechex($rgb[$i])) == 1){
           		$hex[$i] = "0".$hex[$i];
      		}
  		}
  		return $hex;
	}
	for($_i=0;$_i<=10;$_i++) {
		$_cor = Array(mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
		$_hcor = rgb2hex($_cor);
		echo "<span style='background-color: #{$_hcor[0]}{$_hcor[1]}{$_hcor[2]};'>" . 
				"&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;</span>&nbspCOR: #{$_hcor[0]}{$_hcor[1]}{$_hcor[2]}<br/> ";
	}
?>
