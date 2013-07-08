<?php
	$_a= fopen("http://www.php.net/index.php","r");
	if($_a!==FALSE) {

		while(ord($_c=fgetc($_a))!=10) {
			echo htmlentities($_c);
		}
	}
	fclose($_a);
?>
