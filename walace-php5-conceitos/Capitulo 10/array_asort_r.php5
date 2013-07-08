<?php
	$_arr = Array("Nome 1"=>"Walace",
						"Nome 2"=>"Mara",
						"Nome 3"=>"Carol",
						"Nome 4"=>"Isabelle",
						"Nome 5"=>"Ivanilza");
	echo "<pre>";
	asort($_arr);
	print_r($_arr);
	arsort($_arr);
	echo "<br/>";
	print_r($_arr);
	echo "</pre>";
?>
