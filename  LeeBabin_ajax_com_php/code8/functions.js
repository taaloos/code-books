	
	//functions.js
	
	//Function to hide or show the menu.
	function showmenu (){
		if (document.getElementById("themenu").style.visibility == "hidden" || document.getElementById("themenu").style.visibility == ""){
			//Show the menu.
			document.getElementById("themenu").style.visibility = "visible";
		} else {
			//Hide the menu.
			document.getElementById("themenu").style.visibility = "hidden";
		}
	}
	
	function loadTotals(col, numCols, numRows){
		
		var total = 0;
		var cellId = 0;
		for (var row = 1; row <= numRows; row ++) {
			
			if (row == 1){
				cellId = (col + 1);
			} else {
				cellId = (cellId + parseInt (numCols));
			}
			
			id = "box" + cellId;

			if (document.getElementById(id)){
				val = parseInt(document.getElementById(id).value);
		
				if (!isNaN(val)){
					total += val;
				}
			}
		}
	
		document.getElementById('tot' + col).innerHTML = total;
	}
	
	//Function to create a text box.
	function createtext (where, col, counter, numCols, numRows){
		if (where.innerHTML == "" || where.innerHTML == "&nbsp;"){
			where.innerHTML = "<input id=\"box" + counter + "\" type=\"text\" class=\"noshow\" onblur=\"loadTotals (" + col + ",'" + numCols + "','" + numRows + "')\" />";
			document.getElementById("box"+counter).focus();
		}
	}