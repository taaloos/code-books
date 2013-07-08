<?php
	echo "c:\\PHP<br/>";
	foreach(scandir("c:\\PHP",1) as $_arq) {
  		if(substr($_arq,0,1)=="." AND strlen($_arq)<=2) {
	 		continue;
	  	}
		echo "$_arq  <br/>";
	}
	// Exemplo 2--- 
	echo "<br/>Conteudo de: ftp://ftp.mysql.com/lib/<br/>";
	foreach(scandir("ftp://ftp.mysql.com/") as $_arq) {
	   echo "$_arq  <br/>";
	}
?>
