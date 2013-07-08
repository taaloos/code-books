<?php
	$_arr = range('a','Z');
	echo "<pre>";
	print_r($_arr);
	shuffle($_arr);
	print_r($_arr);
	echo "</pre>";
?>
<br/>
<?php
	$_arr = Array("Nome 5"=>"Walace",
						"Nome 3"=>"Mara",
						"Nome 1"=>"Carol",
						"Nome 4"=>"Isabelle",
						"Nome 2"=>"Ivanilza");
	echo "<pre>";
	print_r($_arr);
	shuffle($_arr);
	print_r($_arr);
	echo "</pre>";
?>
