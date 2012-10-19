	
	//functions.js
	
	// Create the marker and corresponding information window
	function createInfoMarker(point, theaddy) {
		var marker = new GMarker(point);
		GEvent.addListener(marker, "click",	function() {
				marker.openInfoWindowHtml(theaddy);
			}
		)
		return marker;
	}

	function loadmap (){
		var map = new GMap(document.getElementById("map"));
		map.addControl(new GLargeMapControl());
		map.addControl(new GMapTypeControl());
		map.centerAndZoom(new GPoint(-114.06,51.05), 7);
		
		var request = GXmlHttp.create();
		request.open('GET', 'locations.xml', true);
		request.onreadystatechange = function() {
			if (request.readyState == 4) {
				var xmlDoc = request.responseXML;
				var markers = xmlDoc.documentElement.getElementsByTagName("marker");
				for (var i = 0; i < markers.length; i++) {
					var point = new GPoint(parseFloat(markers[i].getAttribute("lng")),parseFloat(markers[i].getAttribute("lat")));
					var theaddy = "<div style=\"width: 250px;\"><span style=\"font-size: 10px; font-family: verdana;\"><b>" + markers[i].getAttribute("storename") + "</b><br />" + markers[i].getAttribute("theaddress") + "<br />" + markers[i].getAttribute("city") + ", " + markers[i].getAttribute("province") + "<br />" + markers[i].getAttribute("postal") + "</span></div>";
					var marker = createInfoMarker(point, theaddy);
					map.addOverlay(marker);
				}
			}
		}
		request.send(null);
	}
	
	function trim(str){
    	return str.replace(/^(\s+)?(\S*)(\s+)?$/, '$2');
    }
    
    //An array for error messages.
	var errorArr = Array ();
	var counter = 0;
	
	//Function to validate the newloc form.
	function validateloc (thevalue, thename){
		
		var nowcont = true;
		
		if (thename == "busname"){
			if (trim (thevalue) == ""){
				errorArr[counter] = "You must enter a location name.";
				counter++;
			}
		}
		if (thename == "address"){
			if (trim (thevalue) == ""){
				errorArr[counter] = "You must enter an address.";
				counter++;
			}
		}
		if (thename == "city"){
			if (trim (thevalue) == ""){
				errorArr[counter] = "You must enter the city.";
				counter++;
			}
		}
		if (thename == "province"){
			if (trim (thevalue) == ""){
				errorArr[counter] = "You must enter the province.";
				counter++;
			}
		}
		if (thename == "postal"){
			if (trim (thevalue) == ""){
				errorArr[counter] = "You must enter a postal code.";
				counter++;
			}
		}
		if (thename == "latitude"){
			if (trim (thevalue) == ""){
				errorArr[counter] = "You must enter the latitude.";
				counter++;
			}
		}
		if (thename == "longitude"){
			if (trim (thevalue) == ""){
				errorArr[counter] = "You must enter the longitude.";
				counter++;
			}
		}
		
	}
	
	var aok;
	
	//Functions to submit a form.
	function getformvalues (fobj, valfunc){
		
		var str = "";
		aok = true;
		
		//Empty the error array and reset the counter.
		errorArr.length = 0;
		counter = 0;
			
		//Run through a list of all objects contained within the form.
		for(var i = 0; i < fobj.elements.length; i++){
			//Deal with the form elements differently depending on type.
   			switch(fobj.elements[i].type) {
	   			case "text":
	   				if(valfunc) {
		   				val = valfunc (fobj.elements[i].value,fobj.elements[i].name);
	   				}
	   				str += fobj.elements[i].name + "=" + escape(fobj.elements[i].value) + "&"; 
	   				break;
   			}
		}
		
		if (errorArr.length > 0){
			var errMsg = "The following errors have occurred: \n";
			for (var i = 0; i < errorArr.length; i++){
				errMsg += errorArr[i] + "\n";
			}
			alert (errMsg);
			aok = false;
		}
		return str;
	}
	
	function runajax (file,str,objID) {
		
		//If the validation is ok.
		if (aok == true){
		
			var obj = document.getElementById(objID);
			var doc = null;
			
			try {
				doc = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					doc = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (E) {
					doc = false;
				}
			}
			
			if (!doc && typeof XMLHttpRequest != 'undefined') {
				doc = new XMLHttpRequest();
			}
					
			doc.open("POST", file, true);
			doc.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			doc.onreadystatechange = function() {
				if (doc.readyState == 4 && doc.status == 200) {
					obj.innerHTML = doc.responseText;
				}
			}
			doc.send(str);
		}
	}
	
	function submitform (theform, serverPage, objID, valfunc){
		
		//Clear the default values.
		//An array of default values.
		var defArray = Array ("-- name --","-- address --","-- city --","-- province --","-- postal --","-- latitude --","-- longitude --");
		for(var i = 0; i < theform.elements.length; i++){
			//Deal with the form elements differently depending on type.
			if (theform.elements[i].type == "text"){
				//Check if the value is in the default array.
				for (var j = 0; j < defArray.length; j++){
					if (defArray[j] == theform.elements[i].value){
						theform.elements[i].value = "";
					}
				}
			}
		}
		
		//Create a loading message.
		document.getElementById("map").innerHTML = "<b>Loading...</b>";
		//Process the form.
		var file = serverPage;
		var str = getformvalues(theform,valfunc);
		xmlReq = runajax (file,str,objID);
		//Then reload the map.
		setTimeout ("loadmap()",1000);
	}