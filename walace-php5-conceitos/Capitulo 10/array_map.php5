<?php
	function hipotenusa($ca,$co) {
		return number_format(sqrt(pow($ca,2)+pow($co,2)),2,",",".");
	}
	$_arr_ca = Array(7,11,5,9,3,15,21);
	$_arr_co = Array(2,5,0,25,4,31,45);
	echo "<pre>";
	print_r(array_map("hipotenusa",$_arr_ca,$_arr_co));
	echo "</pre>";
?>
