
	//functions.js

	//Function to load hockey scores in.
	function loadthescores(){
		//Let the user know that the scores are loading.
		document.getElementById("loadscores").innerHTML = "<b>Loading...</b>";
		//Load an ajax request into the hockey scores area.
		processajax ('sample9_1client.php','loadscores','get','');
		//Then set a time out to run this function every minute to keep things up to date.
		setTimeout ('loadthescores()',6000);
	}