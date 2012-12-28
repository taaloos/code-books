<?php
	//sample12_3.php
	if ($_POST['myvalue']){
		//Clean the string to create the dynamic query.
		$myvalue = mysql_real_escape_string ($_POST['myvalue']);
		//You would now be clear to use this in a dynamic query such as:
		$myquery = "SELECT something FROM somewhere WHERE somevalue='" . $myvalue . "'";
	}
?>