<?php
	$_com = 'foreach($_c as $_k=>$_v) { 
					$_t = $_v*1024;
					echo "$_k=>$_t<br/>";
				  }';
	$_c = Array(8,12,1024,32,256);
	eval($_com);
?>
