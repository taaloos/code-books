<?php
	// Retorna o alfabeto em minúsculas
	for($i=97;$i<123;$i++) {
		echo chr($i) . " ($i)" . ($i<122 ? ", "  : "");
	}
?>
