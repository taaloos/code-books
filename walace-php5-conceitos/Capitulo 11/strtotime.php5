<?php
	echo date("d-m-Y H:i:s",strtotime("now")), "<br/>";
	echo date("d-m-Y H:i:s",strtotime("10 September 2004 08:22pm")), "<br/>";
	echo date("d-m-Y H:i:s",strtotime("+1 day")), "<br/>";
	echo date("d-m-Y H:i:s",strtotime("+1 week")), "<br/>";
	echo date("d-m-Y H:i:s",strtotime("+1 week 2 days 4 hours 2 seconds")), "<br/>";
	echo date("d-m-Y H:i:s",strtotime("next Thursday")), "<br/>";
	echo date("d-m-Y H:i:s",strtotime("last Monday"));
?>
