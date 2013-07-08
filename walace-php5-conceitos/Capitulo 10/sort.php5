<?php
	$_arr = Array("Nome 5"=>"Walace",
						"Nome 3"=>"Mara",
						"Nome 1"=>"Carol",
						"Nome 4"=>"Isabelle",
						"Nome 2"=>"Ivanilza");
	echo "<pre>";
	sort($_arr);
	print_r($_arr);
	rsort($_arr);
	echo "<br/>";
	print_r($_arr);
	echo "</pre>";
?>
