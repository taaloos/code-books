<?php
	//process_form.php
		
	//Function to create an XML document out of the saved store locations.
	function createxml ($db, $outputfile){
		//Attempt to open the file.
		try {
			if (!$file = fopen ($outputfile,"w")){
				throw new exception ("Sorry, the file could not be opened for writing.");
			} else {
				//Begin writing the XML document.
				//Output the version number.
				fwrite ($file, "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n");
				//Then the wrapper tag.
				fwrite ($file, "<markers>\n");
				//Now, run through the database and grab any instances of a store.
				if ($storequery = mysql_query ("SELECT * FROM store ORDER BY storeid ASC")){
					while ($storedata = mysql_fetch_array ($storequery)){
						fwrite ($file, "\t<marker lat=\"". $storedata['latitude'] . "\" lng=\"". $storedata['longitude'] . "\" storename=\"". $storedata['name'] . "\" theaddress=\"". $storedata['address'] . "\" city=\"". $storedata['city'] . "\" province=\"". $storedata['province'] . "\" postal=\"". $storedata['postal'] . "\" />\n");
					}
				} else {
					header ("Location: theform.php?message=Data Error: ".mysql_error()."");
					exit;
				}
				//Close the wrapper tag.
				fwrite ($file, "</markers>");
			}
		} catch (exception $e){
			header ("Location: theform.php?message=".urlencode ($e->getmessage())."");
			exit;
		}
	}
	
	//Prepare an array to associate error messages with field names.
	$fieldarr = array ("Sorry, you must enter your business name." => 'busname',
						"Sorry, you must enter the address." => 'address',
						"Sorry, you must enter the city." => 'city',
						"Sorry, you must enter the province." => 'province',
						"Sorry, you must enter the postal code." => 'postal',
						"Sorry, you must enter the latitude." => 'latitude',
						"Sorry, you must enter the longitude." => 'longitude');
	
	//Start an error array.
	$errarr = array ();
						
	//First, validate for proper form fields.
	foreach($_POST as $key => $val){
		if (trim ($val) == ""){
			$errarr[] = array_search ($key, $fieldarr);
		}
	}
	
	//Return an error message if necessary.
	if (count ($errarr) > 0){
		$errmsg = "You have the following errors: <br />";
		for ($i = 0; $i < count ($errarr); $i++){
			$errmsg .= $errarr[$i] . "<br />";
		}
		header ("Location: theform.php?message=" . urlencode ($errmsg) . "");
		exit;
	}
	
	//Open the database.
	try {
		//Connect to the database.
		if (!$db = mysql_connect ("localhost","ensbabin_phpanda","retail")){
			throw new exception (mysql_error());
		} else {
			//Select a database.
			try {
				if (!mysql_select_db ("ensbabin_store")){
					throw new exception (mysql_error());
				}
			} catch (exception $e){
				header ("Location: theform.php?message=Data Error: ".$e->getmessage()."");
				exit;
			}
		}
	} catch (exception $e) {
		header ("Location: theform.php?message=Data Error: ".$e->getmessage()."");
		exit;
	}
	
	//Prepare the data for insertion into the database.
	$busname = mysql_real_escape_string (htmlspecialchars (trim (stripslashes ($_POST['busname']))));
	$address = mysql_real_escape_string (htmlspecialchars (trim (stripslashes ($_POST['address']))));
	$city = mysql_real_escape_string (htmlspecialchars (trim (stripslashes ($_POST['city']))));
	$province = mysql_real_escape_string (htmlspecialchars (trim (stripslashes ($_POST['province']))));
	$postal = mysql_real_escape_string (htmlspecialchars (trim (stripslashes ($_POST['postal']))));
	$latitude = mysql_real_escape_string (htmlspecialchars (trim (stripslashes ($_POST['latitude']))));
	$longitude = mysql_real_escape_string (htmlspecialchars (trim (stripslashes ($_POST['longitude']))));
		
	//Insert the record.
	$myquery = "INSERT INTO store (name, address, city, province, postal, latitude, longitude) VALUES ('$busname','$address','$city','$province','$postal','$latitude','$longitude')";
	//Execute the query.
	try {
		if (!mysql_query ($myquery)){
			throw new exception (mysql_error());
		} else {
			//Create an XML file for the google map to read.
			createxml ($db, "locations.xml");
			
			//Close the database link.
			mysql_close ($db);
			
			//If all goes well, return to the form with a success message.
			header ("Location: theform.php?message=".urlencode ("Congratulations, your location has been successfully added.")."");
			exit;
		}
	} catch (exception $e){
		header ("Location: theform.php?message=Data Error: ".urlencode ($e->getmessage())."");
		exit;
	}
				
?>