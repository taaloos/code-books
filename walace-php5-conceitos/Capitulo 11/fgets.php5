<?php
	$_a= fopen("http://static.php.net/www.php.net/images/php.gif","r");
	if($_a!==FALSE) {
		while(!feof($_a)) {
		  echo fgets($_a,4096);
		}
	}
	fclose($_a);
?>
