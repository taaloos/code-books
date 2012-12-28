<?php

	//process_task.php

	//Create a connection to the database.
	require_once ("dbconnector.php");
	opendatabase();
	
	//Validate.
	if (trim ($_POST['yourname']) == ""){
		header ("Location: theform.php?message=Please enter your name.");
		exit;
	}
	if (trim ($_POST['yourtask']) == ""){
		header ("Location: theform.php?message=Please enter a task.");
		exit;
	}
	
	//Now, prepare data for entry into the database.
	$yourname = strip_tags (mysql_real_escape_string ($_POST['yourname']));
	$yourtask = strip_tags (mysql_real_escape_string ($_POST['yourtask']));
	$thedate = strip_tags (mysql_real_escape_string ($_POST['thedate']));
	
	//Build a dynamic query.
	$myquery = "INSERT INTO task (taskid, yourname, thedate, description) VALUES ('0','$yourname','$thedate','$yourtask')";
	
	//Execute the query (and send an error message if there is a problem).
	if (!mysql_query ($myquery)){
		header ("Location: theform.php?message=There was a problem with the entry.");
		exit;
	}
	
	//If all goes well, return.
	header ("Location: theform.php?message=success");
?>