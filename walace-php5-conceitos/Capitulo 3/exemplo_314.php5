<?php
	$s = "PHP5";
	$n = 10;
	$b = TRUE;
	$nulo = NULL;
	class classe {
		var $var1;
		var $var2;
		function classe() {
			$this->var1 = 10;
			$this->var2 = "classe";
		}
	}

	$c = new classe;
	echo "<pre>";
	print_r((array) $s);
	print_r((array) $n);
	print_r((array) $b);
	print_r((array) $nulo);
	print_r((array) $c);
	echo "</pre>";
?>

