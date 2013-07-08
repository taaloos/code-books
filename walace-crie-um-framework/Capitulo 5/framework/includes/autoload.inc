<?php
	function framework_autoload($_classe) {
		if($_classe=='formulariorelatorio') { $_classe = 'relatorio';}
		if(file_exists("framework/classes/classe_{$_classe}.inc")) {
			include_once("framework/classes/classe_{$_classe}.inc");
			return true;
		}
		return false;
	}
	
	function __autoload($_classe) {
		$_classe = strtolower($_classe);
		if(framework_autoload($_classe)===false) {
			if(function_exists("SISTEMA_autoload")) {
				SISTEMA_autoload($_classe);
			} else {
				die("<span style='color:red;font-size:20px;text-align:center;'>Classe {$_classe} não Existe...</span>");
			}
		}
	}
?>