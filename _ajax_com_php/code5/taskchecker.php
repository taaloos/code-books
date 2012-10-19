<?php

	//taskchecker.php

	//Add in the database connector.
	require_once ("dbconnector.php");
	//Open the database.
	$db = opendatabase();
	
	$myquery = "SELECT * FROM task WHERE thedate='" . addslashes ($_GET['thedate']) . "'";
	
	if ($datequery = mysql_query ($myquery)){
		if (mysql_num_rows ($datequery) > 0){
			?>
			<div style="width: 150px; background: #FFBC37; border-style: solid; border-color: #000000; border-width: 1px;">
				<div style="padding: 10px;">
					<?php
						while ($datedata = mysql_fetch_array ($datequery)){
							echo $datedata['description'];
						}
					?>
				</div>
			</div>
			<?php
		}
	} else {
		echo "There was an error processing your request.";
	}
	
	//Close the database connection.
	mysql_close ($db);
	
?>