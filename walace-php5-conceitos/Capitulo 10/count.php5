<?php
	$_arr = Array(2,7,"a"=>array(5,8,9),"b",13,17);
	echo count($_arr);
	echo "<br/>";
	echo count($_arr,COUNT_RECURSIVE);
?>
