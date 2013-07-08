<?php
	function cubo($_item,$_ind) {
		$_res = pow($_item,3);
		echo "[$_ind] O cubo de $_item é  $_res<br/>";
	}
	function soma(&$_item,$_ind,$_k=1) {
		$_item+=$_k;
	}
	$_arr = Array(1,3,5,7,8,13,17);
	array_walk($_arr,"cubo");
	array_walk($_arr,"soma",7);
	echo "<br/><br/>";
	array_walk($_arr,"cubo");
?>
