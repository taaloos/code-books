<?php
	function teste() {
		static $v = 10;
		$v++;
		echo $v . "<br>";
	}
   	teste();
	teste();
	teste();
?>
