<?php
	echo "Chamando uma função";
	minha_função();
	echo "Fim";
	function minha_função() {
		echo "<br>";
		for($i=0;$i<5;print "<br>",$i++) {
			echo "o Quadrado de $i  é " . ($i*$i);
		}
	}
?>




