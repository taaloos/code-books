<?php
	function verifica_arq($_arq) {
		if(file_exists($_arq)) {
			if(is_dir($_arq)) {
				echo "$_arq é um diretório<br/>";
			}
			elseif(is_executable($_arq)) {
			    echo "$_arq é um Executavél<br/>";
			}
			elseif(is_file($_arq)) {
				echo "$_arq é um Arquivo<br/>";
			}
			else {
			    echo "$_arq é um qualquer outra coisa<br/>";
			}
			return TRUE;
		}
		else  {
			echo "$_arq não Existe<br/>";
			return FALSE;
		}
	}

	// Exemplos....
	verifica_arq("C:\\PHP");
	verifica_arq("C:\\PHP\\php.exe");
	verifica_arq("ftp://ftp.mysql.com/lib/libc.so.6");
	
?>
