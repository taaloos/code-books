<?php
	function valida_script($_dir,$_ext="php5") {		
		foreach(scandir($_dir) as $_arq) {
			$_a = pathinfo("$_dir/$_arq");
			if($_a["extension"]==$_ext) {
				$_r = &php_check_syntax("$_dir/$_arq",$_err); 
				if($_r===TRUE) {
					continue;
				}
				else {
					echo "$_arq [NOK] $_err";
				}
				echo "<br/>";
			}
		}
	}
	valida_script("./");
?>
