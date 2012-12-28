	
	//sample12_2.js
	
	//Function to process an XMLHttpRequest.
	function processajax (serverPage, obj, getOrPost, str){
		//Get an XMLHttpRequest object for use.
		var xmlhttp = getxmlhttp ();
		
		//Send a GET request.
		if (getOrPost == "get"){
			xmlhttp.open("GET", serverPage);
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					obj.innerHTML = xmlhttp.responseText;
					return true;
				}
			}
			xmlhttp.send(null);
		} else {
			//Send a POST request.
			xmlhttp.open("POST", serverPage, true);
			//Set the header.
			xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					obj.innerHTML = xmlhttp.responseText;
					return true;
				}
			}
			xmlhttp.send(str);
		}
	}