<?php
	$i=10;
    echo "Primeiro while: ";
	while($i>0) {
		echo "$i ... ";
		$i--;
	}

	$k=10;
	echo "<br>Primeiro do..while: ";
	do {
		echo "$k ... ";
		$k--;
	} while($k>0);
	
	echo "<br>Segundo while (não teremos nenhuma iteração): ";
	while($i>0) {
		echo "$i  /  ";
		$i--;
	}
	
	echo "<br>Segundo do..while (1 iteração): ";
	do {
		echo "$k ... ";
		$k--;
	} while($k>0);
	
?>
