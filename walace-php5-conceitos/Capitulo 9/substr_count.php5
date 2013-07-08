<?php
	$dir=opendir("./"); 
	while($file=readdir($dir)) { 
 	    $texto.=$file . "; ";    
	}
    echo $texto . "<br>";
	echo "Número de ocorrências de str: " . substr_count($texto,"str") . "<br>";
	echo "Número de ocorrências de PHP5: " . substr_count($texto,"PHP5"); 	
?>

