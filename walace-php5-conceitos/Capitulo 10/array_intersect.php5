<?php
	$_arr = Array("a"=>10,"b"=>5,7,12,11,15);
	$_ar2 = Array("a"=>10,"b"=>8,7,11,"c"=>2,0,15,12);
	echo "<PRE>";
	echo "array_intersect:<br/>";
	print_r(array_intersect($_arr,$_ar2));
	echo "array_intersect_assoc:<br/>";
	print_r(array_intersect_assoc($_arr,$_ar2));
	echo "</PRE>";
?>

