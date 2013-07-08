<?php
  	function converte($_t) {
 		$_1k = 1024;
 		$_1m = pow($_1k ,2);
 		$_1g = pow($_1k,3);
    		return ($_t<$_1k 
          	   			? $_t . " Bytes"
		   			: ($_t < $_1m 
						? round($_t/$_1k,2) . " KB"
						: ($_t < $_1g
					  		? round($_t/$_1m,2) . " MB"
					  		: round($_t/$_1g,2) . " GB"
						)
			 		)
				);
   	}

	$_dir = "./";
	
	echo "$_dir<br/>";
	foreach(scandir($_dir,1) as $_arq) {
  		if(substr($_arq,0,1)=="." AND strlen($_arq)<=2) {
			 		continue;
	  	}
		echo "$_arq  " .  converte(filesize("$_dir/$_arq")) . "<br/>";
	}
	// Exemplo 2--- 
	$_dir = "ftp://ftp.mysql.com/lib/";
	echo "<br/>Conteudo de:  $_dir<br/>";
	foreach(scandir($_dir) as $_arq) {
  		echo "$_arq  " . converte(filesize("$_dir/$_arq")) . "<br/>";
	}
?>
