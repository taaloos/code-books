	
	//functions.js
	
	/** RSH must be initialized after the
	page is finished loading. */
	window.onload = initialize;
	
	function initialize() {
		// initialize RSH
		dhtmlHistory.initialize();
	
		// add ourselves as a listener for history
		// change events
		dhtmlHistory.addListener(handleHistoryChange);
	
		// determine our current location so we can
		// initialize ourselves at startup
		var initialLocation = dhtmlHistory.getCurrentLocation();
	
		// if no location specified, use the default
		if (initialLocation == null){
			initialLocation = "location1";
		}
	
		// now initialize our starting UI
		updateUI(initialLocation, null);
	}
	
	/** A function that is called whenever the user
	presses the back or forward buttons. This
	function will be passed the newLocation,
	as well as any history data we associated
	with the location. */
	function handleHistoryChange(newLocation, historyData) {
		// use the history data to update our UI
		updateUI(newLocation, historyData);                           
	}
	
	/** A simple method that updates our user
	interface using the new location. */
	function updateUI(newLocation, historyData) {
		var output = document.getElementById("output");

		// simply display the location and the
		// data
		var historyMessage;
		if (historyData != null){
			historyMessage = historyData.message;
		}

		var whichPage;
		//Change the layout according to the page passed in.
		switch (newLocation){
			case ("location1"):
				whichPage = "Welcome to Page 1";
				break;
			case ("location2"):
				whichPage = "Welcome to Page 2";
				break;
			case ("location3"):
				whichPage = "Welcome to Page 3";
				break;
		}
		
		var message = "<h1>" + whichPage + "</h1><p>" + historyMessage + "</p>";

		output.innerHTML = message;
	}
	
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
	function processajax (serverPage, obj, str, theform){
		
		//Run the validate script.
		if (validateform(theform)){
			xmlhttp = getxmlhttp();
			xmlhttp.open("POST", serverPage, true);
			xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById(obj).innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.send(str);
		}
	}
	
	//Function to process an XMLHttpRequest.
	function loadajax (serverPage, obj){
		
		showLoadMsg ('Loading...');
		document.getElementById(obj).style.visibility = "visible";
		
		xmlhttp = getxmlhttp();
		xmlhttp.open("GET", serverPage, true);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById(obj).innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.send(null);
		
	}
	
	//Function to output a loading message.
	function showLoadMsg (msg){
		hidden = document.getElementById('loadpanel');
		hidden.innerHTML = '<img src="indicator.gif" alt="" /> ' + msg;
	}
	
	function trim(inputString) {
	   // Removes leading and trailing spaces from the passed string. Also removes
	   // consecutive spaces and replaces it with one space. If something besides
	   // a string is passed in (null, custom object, etc.) then return the input.
	   if (typeof inputString != "string") { return inputString; }
	   var retValue = inputString;
	   var ch = retValue.substring(0, 1);
	   while (ch == " ") { // Check for spaces at the beginning of the string
	      retValue = retValue.substring(1, retValue.length);
	      ch = retValue.substring(0, 1);
	   }
	   ch = retValue.substring(retValue.length-1, retValue.length);
	   while (ch == " ") { // Check for spaces at the end of the string
	      retValue = retValue.substring(0, retValue.length-1);
	      ch = retValue.substring(retValue.length-1, retValue.length);
	   }
	   while (retValue.indexOf("  ") != -1) { // Note that there are two spaces in the string - look for multiple spaces within the string
	      retValue = retValue.substring(0, retValue.indexOf("  ")) + retValue.substring(retValue.indexOf("  ")+1, retValue.length); // Again, there are two spaces in each of the strings
	   }
	   return retValue; // Return the trimmed string back to the user
	} // Ends the "trim" function
	
	//Function to validate the newloc form.
	function validateform (theform){
		
		if (trim (theform.yourname.value) == ""){
			alert ("Please enter your name.");
			theform.yourname.focus();
			return false;
		}
		
		if (!validEmail (trim (theform.youremail.value))){
			alert ("Please enter a valid email address.");
			theform.youremail.focus();
			return false;
		}
		
		return true;
	}
	
	//Functions to submit a form.
	function getformvalues (fobj){
		
		var str = "";
				
		//Run through a list of all objects contained within the form.
		for(var i = 0; i < fobj.elements.length; i++){
			str += fobj.elements[i].name + "=" + escape(fobj.elements[i].value) + "&";
		}
		//Then return the string values.
		return str;
	}
	
	//Function to validate email addresses
	function validEmail(email){
		invalidChars = " /:,;";
		
		if (email == ""){
			return false;
		}
		
		for (i=0; i<invalidChars.length; i++){
			badChar = invalidChars.charAt(i);
			if (email.indexOf(badChar,0) > -1){
				return false;
			}
		}
		atPos = email.indexOf("@",1);
		if (atPos == -1){
			return false;
		}
		if (email.indexOf("@",atPos+1) > -1){
			return false;
		}
		periodPos = email.indexOf(".",atPos);
		if (periodPos+3 > email.length){
			return false;
		}
		return true;
	}