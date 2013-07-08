<?php
	for($i=0;$i<=10;$i++) {
		echo "$i ... ";
	}
	for(print "<br>";$i>=0;$i--) {
		echo "$i ... ";
	}
	echo "<br>";
	for(;;) {
		if($i>20) {
			break;
		}
		echo "$i ... ";
		$i+=2;
	}
	echo "<br>";
  	for($i=5;$i<=30;print "$i ... ", $i+=5);
?>
