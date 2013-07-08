<?php
	function exclui_arquivos($_dir,$_suf="TODOS") {
		if(is_dir($_dir)) {
			$_d = opendir($_dir);
			while(($_f = readdir($_d))!==FALSE) {
				if($_f!='.' && $_f!='..') {
					if(!is_dir("$_dir/$_f")) {
						$_a = pathinfo("$_dir/$_f");
						if($_suf=="TODOS" OR 
						    $_a["extension"]==$_suf) {

							if(!unlink("$_dir/$_f")) {
								return FALSE;
							}
						}
					}
				}
			}
			closedir($_d);
			return TRUE;
		}
		else {
			return FALSE;
		}
	}		
	
	// Exemplo
	if(exclui_arquivos("C:\\TEMP\\OLD_PHP5_001\\","dll") ===TRUE) {
			echo "Arquivos Excluidos..";
	}
	else {
		echo "Erro na Exclusão";
	}
?>
