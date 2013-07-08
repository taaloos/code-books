<?php
	$_arr = Array("Nome 5"=>"Walace",
						"Nome 3"=>"Mara",
						"Nome 1"=>"Carol",
						"Nome 4"=>"Isabelle",
						"Nome 2"=>"Ivanilza");
	$_k1 = reset($_arr);
	echo $_k1 . "<br/>";
	$_k1 = current($_arr);
	echo $_k1 . "<br/>";
	$_k1 = next($_arr);
	echo $_k1 . "<br/>";
	$_k1 = current($_arr);
	echo $_k1 . "<br/>";
	$_k1 = end($_arr);
	echo $_k1 . "<br/>";
	$_k1 = current($_arr);
	echo $_k1 . "<br/>";
	$_k1 = prev($_arr);
	$_k1 = prev($_arr);
	echo $_k1 . "<br/>";
	$_k1 = current($_arr);
	echo $_k1 . "<br/>";
	$_k1 = key($_arr);
	echo $_k1 . "<br/>";
?>
