<?php
	$ip  = $_SERVER["REMOTE_ADDR"];
	if(substr($ip,0,3)=="127") {
		echo "LocalHost";
	}
	else {
		echo $ip;			
	}
?>
