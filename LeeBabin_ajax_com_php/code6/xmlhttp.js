	
	//xmlhttp.js
	
	//Function to create an XMLHttp Object.
	function getxmlhttp (){
		//Create a boolean variable to check for a valid microsoft active X instance.
		var xmlhttp = false;
		
		//Check if we are using internet explorer.
		try {
			//If the javascript version is greater than 5.
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			//If not, then use the older active x object.
			try {
				//If we are using internet explorer.
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (E) {
				//Else we must be using a non-internet explorer browser.
				xmlhttp = false;
			}
		}
		
		//If we are using a non-internet explorer browser, create a javascript instance of the object.
		if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
			xmlhttp = new XMLHttpRequest();
		}
		
		return xmlhttp;
	}
	
	//Function to process an XMLHttpRequest.
	function processajax (obj, serverPage){
		//Get an XMLHttpRequest object for use.
		var theimg;
		xmlhttp = getxmlhttp ();
		xmlhttp.open("GET", serverPage);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById(obj).innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.send(null);
	}