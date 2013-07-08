<?php
	function fatorial($n) {
		if($n<0) {
			return "Não existe fatorial de número negativo";
		}
		elseif($n<=1) {
			return 1;
		}
		else {
			return $n * fatorial($n-1);
		}
	}
	$v = 10;
	echo "Fatorial de $v = " . fatorial($v);
?>
