<?php
	$_t = time();
	for($_i=0;$_i<=100000;$_i++) {
		$_x+=$_i*15;
	}
	$_d = time()-$_t;
	echo date("i:s",$_d);
?>
