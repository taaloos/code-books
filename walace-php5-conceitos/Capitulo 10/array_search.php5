<?php
	$_arr = Array(2,3,5,1,8,2,-1,-10, array(23,37,53));
	$_k1 = array_search(5,$_arr);
	$_k2 = array_search("5",$_arr);
	$_k3 = array_search("5",$_arr,TRUE);
	echo $_k1 . " ::: " . $_k2 . " :: " . (int)$_k3; 
?>
