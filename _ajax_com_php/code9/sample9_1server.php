<?php

	//sample9_1server.php

	//Require the nusoap library.
	require_once("lib/nusoap.php");
	
	//Create an instance of a server.
	$server = new soap_server();
	
	//Register any methods to make available.
	$server->register('gethockeygame',         // method name
		array('thedate' => 'xsd:string'),      // input parameters
		array('return' => 'xsd:string')        // output parameters
	);
	
	//A function to return information on a hockey game
	//based on a passed in date.
	function gethockeygame ($thedate) {
		
		//XML document location.
		$xmldoc = "myxml.xml";
		
		//Open XML for reading.
		if ($file = fopen ($xmldoc,"r")){
			//Load the file using simplexml.
			$xml = simplexml_load_file ($xmldoc);
			$count = 0;
			//Parse through each game.
			foreach ($xml->game as $game){
				$count++;
				//If we find a game matching the passed in date.
				if ($game->gamedate == $thedate){
					//Add to a return string.
					//Use the &raquo; symbol as a seperator.
					if ($count != 1){
						$returnstr .= "&raquo;";
					}
					$returnstr .= $game->team1->teamname . " (" . $game->team1->score . ") at " . $game->team2->teamname . " (" . $game->team2->score . ")";
				}
			}
		} else {
			$returnstr = "Sorry, could not open the file.";
		}
		return $returnstr;
	}
	
	// Use the request to (try to) invoke the service
	$HTTP_RAW_POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

	$server->service($HTTP_RAW_POST_DATA);
	
?>