<?php
	function rm_recursivo($_arq) {
		if(is_dir($_arq)) {
			$_d = opendir($_arq);
			while(($_f = readdir($_d))!==FALSE) {
				if($_f!='.' && $_f!='..') {
					if(rm_recursivo("$_arq/$_f")===FALSE)
						return FALSE;
				}
			}
			closedir($_d);
			echo "[d] $_arq<br/>";
			return rmdir($_arq);
		}
		else {
			echo "...[f] $_arq<br/>";
			return unlink($_arq);
		}
	}

	// Exemplo
	if(rm_recursivo("c:\\TEMP\\PHP5")===TRUE) {
			echo "Diretório Excluido..";
	}
	else {
		echo "Erro na Exclusão";
	}
?>
