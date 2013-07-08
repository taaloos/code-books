<?php
	$dir=opendir("./"); 
	while($file=readdir($dir)) { 
   		if(strtolower(substr($file,0,3))=="str") {
   			$texto.=$file . "; ";    
		}
	}
	$texto = strtolower($texto);
	$texto = ucwords($texto);
	echo $texto;
?>
