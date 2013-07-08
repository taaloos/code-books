<?php
	$_arr = Array("a"=>"PHP",2,3,5,1,8,2,-1,-10);
	$_k1 = array_slice($_arr,0,3);
	$_k2 = array_slice($_arr,-3,1);
	$_k3 = array_slice($_arr,2,-2);
	$_k4 = array_slice($_arr,4);
	echo "<pre>";
	print_r($_k1);
	print_r($_k2);
	print_r($_k3);
	print_r($_k4);
	echo "</pre>";
?>
