<?php
   function converte($_t) {
	 $_1k = 1024;
	 $_1m = pow($_1k ,2);
	 $_1g = pow($_1k,3);
     return ($_t<$_1k 
           	   ? $_t . " Bytes"
			   : ($_t < $_1m 
					? round($_t/$_1k,2) . " KB"
					:  ($_t < $_1g
						  ? round($_t/$_1m,2) . " MB"
						  : round($_t/$_1g,2) . " GB"
						)
				 )
			);
    }
    function esp_livre($driver) {
		$_total = disk_free_space($driver);
        $_tam   = disk_total_space($driver);
		return "Espaço Livre em $driver " . converte($_total) . 
               " de um total de " . converte($_tam);
                
	}
	echo esp_livre("C:") . "<br>";
	echo esp_livre("D:");
?>
