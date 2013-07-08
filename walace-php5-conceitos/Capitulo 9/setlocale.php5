<?php
	 $local = setlocale(LC_NUMERIC,"");
	 echo $local;
	 echo "<br>";
	 echo number_format(1254.35,2);
	 echo "<br>";	 
	 echo date("d M Y H:i:s",time()+30*86400);
	 echo "<br>";
	 echo strftime("%A %e %B %Y",time());
?>
