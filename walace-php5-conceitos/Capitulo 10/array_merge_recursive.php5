<?php
	$_arr = Array("a"=>10,"b"=>5,7,12,11,15);
	$_ar2 = Array("a"=>10,"b"=>8,7,11,"c"=>2,0,15,12);
	$_ar3 = Array("a"=>Array(11,10,5),"b"=>5,1,2);
	echo "<PRE>";
	print_r(array_merge_recursive($_arr,$_ar2,$_ar3));
	echo "</PRE>";
?>
