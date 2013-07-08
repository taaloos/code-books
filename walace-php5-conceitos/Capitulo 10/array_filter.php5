<?php
	function raiz_quadrada($vlr) {
	    $s = sqrt($vlr);
		return ($s!=(int)$s ? FALSE : TRUE);
	}
	
	$_arr = Array(4,7,9,13,15,18,25,225,169);
	echo "<PRE>";
	print_r(array_filter($_arr,"raiz_quadrada"));
	echo "</PRE>";
?>

