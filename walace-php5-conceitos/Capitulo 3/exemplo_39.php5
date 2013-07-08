<?php
	$con = mysql_connect("localhost","root","");
	echo $con . "<br>";
	if(is_resource($con))
      echo get_resource_type($con);
?>
