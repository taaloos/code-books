<?php
	function esp_livre($driver) {
		$_1k = 1024;
		$_1m = pow($_1k ,2);
		$_1g = pow($_1k,3);
		$_total = disk_free_space($driver);
		return "Espaço Livre em $driver " . 
				 ($_total<$_1k 
               				? $_total . " Bytes"
						: ($_total < $_1m 
								? round($_total/$_1k,2) . " KB"
								:  ($_total < $_1g
										? round($_total/$_1m,2) . " MB"
										: round($_total/$_1g,2) . " GB"
									)
							)
					);
	}
	echo esp_livre("C:") . "<br>";
	echo esp_livre("D:");
?>
