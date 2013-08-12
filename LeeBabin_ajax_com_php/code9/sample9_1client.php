<?php
	//sample9_1client.php
	
	//The first thing we must do is include the nusoap library.
	require_once ("lib/nusoap.php");
	
	//Create the new soap client.
	$client = new soapclient("http://www.babinplanet.ca/prophpandajax/chapter9/code/sample9_1server.php");
	
	//Check for errors.
	if ($client->getError()) {
		echo "There was an error:<br />" . $client->getError();
	}
	
	//Create a parameter list to send to the server function.
	$params = array(
	    "thedate" => '2006-01-23'
	);
	
	//Then make the call to the specified function.
	$result = $client->call('gethockeygame', $params);
	
	//If there was an expected fault...
	if ($client->fault) {
		//Echo the expected fault.
		echo $result;
	} else {
		//Or else deal with error responses.
		if ($client->getError()) {
			echo "An error occurred: " . $client->getError();
		} else {
			//If we get here, then we have a valid result.
			//Explode the results at the &raquo; in case of multiples.
			$expresult = explode ("&raquo;", $result);
			//Default the background color.
			$theclass = "alt1";
			$count = 0;
			for ($i = 0; $i < count ($expresult); $i++){
				$count++;
				if ($expresult[$i] != ""){
					//Output the results.
					?>
					<div class="<?php echo (($i % 2) == 0 ? 'alt1' : 'alt2'); ?>"<?php if ($count == count ($expresult)){?> style="border-width: 0px;"<?php } ?>>
						<div class="pad">
							<?php echo $expresult[$i]; ?>
						</div>
					</div>
					<?php
				}
			}
		}
	}
?>