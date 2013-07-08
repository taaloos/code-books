<?php
	$_arr = Array("a","b","c","e");
	$_r1 = array_pad($_arr,8,"z");
	$_r2 = array_pad($_arr,6,-1);
	$_r3 = array_pad($_r1,6,0);
	echo "<PRE>";
	print_r($_r1);
	print_r($_r2);
	print_r($_r3);
	echo "</PRE>";
?>
