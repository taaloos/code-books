<?php
	$_arr = Array("a"=>10,"b"=>5,7,12,11,15);
	$_ar2 = Array("a"=>10,"b"=>8,7,11,"c"=>2,0,15);
	echo "<PRE>";
	print_r(array_diff_assoc($_arr,$_ar2));
	echo "</PRE>";
?>

