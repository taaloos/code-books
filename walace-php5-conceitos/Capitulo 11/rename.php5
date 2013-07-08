<?php
	function altera_arquivos($_dir,$_pref="",$_suf="") {
		if(!is_dir($_dir)) {
			return FALSE;
		}
  		foreach(scandir($_dir) as $_arq) {
 			if(substr($_arq,0,1)=="." AND strlen($_arq)<=2) {
 				continue;
  			}
			if(!rename("$_dir/$_arq","$_dir/{$_pref}$_arq{$_suf}")) {
				return FALSE;
			}
  		}
	}

	// Exemplo
	altera_arquivos("C:\\TEMP","OLD_","_001");
?>
