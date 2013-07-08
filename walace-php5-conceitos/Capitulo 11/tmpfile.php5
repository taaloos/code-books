<?php
	$_d = tmpfile();
	fwrite($_d,__FILE . "\n");
	fwrite($_d,$_SERVER["HTTP_USER_AGENT"] . "\n");
	fwrite($_d,$_SERVER["REMOTE_ADDR"]);
	rewind($_d);
	while(!feof($_d)) {
		echo fgets($_d,1024) . "<br/>";
	}
	fclose($_d);
?>
