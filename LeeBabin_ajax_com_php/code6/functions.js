
	//functions.js
	
	//Function to determine when the process_upload.php file has finished executing.
	function doneloading(theframe,thefile){
		var theloc = "showimg.php?thefile=" + thefile
		theframe.processajax ("showimg",theloc);
	}
	
	function uploadimg (theform){
		//Submit the form.
		theform.submit();
		//Then display a loading message to the user.
		setStatus ("Loading...","showimg");
	}
	
	//Function to set a loading status.
	function setStatus (theStatus, theObj){
		obj = document.getElementById(theObj);
		if (obj){
			obj.innerHTML = "<div class=\"bold\">" + theStatus + "</div>";
		}
	}
	
	function changesize (img, sml){
		//The display a loading message to the user.
		theobj = document.getElementById("showimg");
		if (theobj){
			setStatus ("Loading...","showimg");
			var loc = "thumb.php?img=" + img + "&sml=" + sml;
			processajax ("showimg",loc);
		}
	}