<?php
	if (extension_loaded('gd')) {
		echo "<pre>";
		print_r(get_extension_funcs("gd"));
		echo "</pre>";
	}
?>
