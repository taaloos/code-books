<?php
	$_arr = Array("a"=>10,"b"=>5,7,12,11,15);
	$_ar2 = Array("a"=>10,"b"=>8,7,11,"c"=>2,0,15,12);
	array_multisort($_arr,SORT_DESC);
	array_multisort($_ar2,SORT_STRING);
	echo "<PRE>";
	print_r($_arr);
	print_r($_ar2);
	echo "</PRE>";
?>
