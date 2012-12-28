<?php

	//autocomp.php

	//Add in our database connector.
	require_once ("dbconnector.php");
	//And open a database connection.
	$db = opendatabase();
	
	$myquery = "SELECT DISTINCT(yourname) FROM task WHERE yourname LIKE LOWER('%" . addslashes($_GET['sstring']) . "%') ORDER BY yourname ASC";
	
	if ($userquery = mysql_query ($myquery)){
		if (mysql_num_rows ($userquery) > 0){
			?>
			<div style="background: #CCCCCC; border-style: solid; border-width: 1px; border-color: #000000;">
			<?php
				while ($userdata = mysql_fetch_array ($userquery)){
					?><div style="padding: 4px; height: 14px;" onmouseover="this.style.background = '#EEEEEE'" onmouseout="this.style.background = '#CCCCCC'" onclick="setvalue ('<?php echo $userdata['yourname']; ?>')"><?php echo $userdata['yourname']; ?></div><?php
				}
			?>
			</div>
			<?php
		}
	} else {
		echo mysql_error();
	}

	
?>