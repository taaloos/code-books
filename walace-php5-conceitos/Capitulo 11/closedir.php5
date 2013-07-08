<?php
    chdir("../");
	$_dir = opendir("./");
	while (($_l=readdir($_dir))!==FALSE) {
		if(substr($_l,0,1)=="." AND strlen($_l)<=2)
 			continue;
		if(is_dir($_l)) { 
               echo "[D] ";
		}
		else {
			echo "[F] ";
		}
   		echo $_l . "<br/>";
	}
	rewinddir($_dir);
	closedir($_dir);

	// Exemplo 2--- 
	echo "<br/>Conteudo de: ftp://ftp.mysql.com/lib/<br/>";
	$_dir = opendir("ftp://ftp.mysql.com/lib/");
	while (($_l=readdir($_dir))!==FALSE) {
   		echo $_l . "<br/>";
	}
	closedir($_dir);

	// Exemplo 3--- 
	echo "<br/>Conteudo de: http://www.zanthus.com.br/<br/>";
	$_dir = opendir("file://www.mysql.com/");
	while (($_l=readdir($_dir))!==FALSE) {
   		echo $_l . "<br/>";
	}
	closedir($_dir);

?>


