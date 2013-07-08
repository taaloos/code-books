<?php
	echo "<PRE>";
	if(in_array("pt-br",$_SERVER)) {
		print_r(array_keys($_SERVER,"pt-br"));
	}
	echo "</PRE>";
?>
