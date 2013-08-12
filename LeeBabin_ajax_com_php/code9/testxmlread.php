<?php
	//A function to return information on a hockey game
	//based on a passed in date.
	function gethockeygame ($thedate) {
		
		//XML document location.
		$xmldoc = "myxml.xml";
		
		//Open XML for reading.
		if ($file = fopen ($xmldoc,"r")){
			//Load the file using simplexml.
			$xml = simplexml_load_file ($xmldoc);
			
			//Parse through each game.
			foreach ($xml->game as $game){
				//If we find a game matching the passed in date.
				if ($game->gamedate == $thedate){
					//Add to a return string.
					//Use the &raquo; symbol as a seperator.
					$returnstr = $game->team1->teamname . " (" . $game->team1->score . ") at " . $game->team2->teamname . " (" . $game->team2->score . ")";
				}
			}
		} else {
			$returnstr = "Sorry, could not open the file.";
		}
		return $returnstr;
	}
	echo gethockeygame("2006-01-23");
?>