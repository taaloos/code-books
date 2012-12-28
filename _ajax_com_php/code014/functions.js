	
	//functions.js
	
	//Function to create a new div element.
	function createDiv (theid){
		//Initiate the variable.
		var mydiv;
			
		//Create the div.
		mydiv = document.createElement("div");
		
		//Set the div's class.
		mydiv.className = "newdiv";
		
		//Add a label to the element.
		mydiv.innerHTML = "Click Me To Change Color";
		
		//Setup an event listener.
		mydiv.onclick = function () { changeColor (this, 'newdivgreen'); };
		
		//Assign the element a unique id.
		mydiv.id = theid;
		
		//This is how to do it using the addEventHandler method.
		//mydiv.addEventListener ('click',function () { changeColor (this, '#00FF00'); }, false);
		
		//Append the div to the body.
		document.body.appendChild (mydiv);
	}
	
	//Function to change an object's color.
	function changeColor (theObj,theClass){
		//Check to ensure the object exists.
		if (theObj){
			//Change the color.
			theObj.className = theClass;
			//theObj.setAttribute ('class',theClass);
		}
	}
	
	//Function to remove an element.
	function removeElement (theid){
		//Check to ensure the element exists.
		theObj = document.getElementById(theid);
		if (theObj){
			theObj.parentNode.removeChild (theObj);
		}
	}
	
	//The number of rows.
	var numRows = 3;
	//The number of columns.
	var numCols = 3;
	
	//Function to create a table.
	function createTable (theid){
				
		var myTable;
		
		//Create the table.
		myTable = document.createElement ("table");
		myTable.className = "tableclass";
		myTable.border = 1;
		myTable.cellpadding = 4;
		myTable.width = "100%";
		myTable.id = theid;
		
		//Add the table.
		document.body.appendChild (myTable);
		
		//Then cycle through the number of rows.
		for (var i = 0; i < numRows; i++){
			var newTr;
			//Find the current number of rows.
			var curRows = myTable.getElementsByTagName("tr").length;
			//Create a new row.
			newTr = myTable.insertRow (curRows);
			newTr.style.height = "30px";
			//Now, create an appropriate number of columns.
			for (var j = 0; j < numCols; j++){
				//Create a new column.
				var myTd;
				myTd = document.createElement ("td");
				myTd.style.width = "20%";
				//Add a "remove" button in the first element of each row.
				if (j == 0){
					myTd.innerHTML = "Click to Remove";
					myTd.onclick = function () { removeRow (myTable, this.parentNode.rowIndex); };
				}
				//Add the column to the listing.
				newTr.appendChild (myTd);
			}
		}
	}
	
	//Function to remove a row.
	function removeRow (theTable, theIndex){
		//Make sure the element exists.
		if (theTable){
			//Remove the row at the selected index.
			theTable.deleteRow (theIndex);
		}
	}
	
	//Function to add a row.
	function addRow (theTable){
		var theObj = document.getElementById(theTable);
		//Check to ensure the object exists.
		if (theObj){
			//Add a new row to the end.
			newTr = theObj.insertRow (theObj.getElementsByTagName("tr").length);
			newTr.style.height = "30px";
			//Then add the columns.
			for (var j = 0; j < numCols; j++){
				//Create a new column.
				var myTd;
				myTd = document.createElement ("td");
				myTd.style.width = "20%";
				//Add a "remove" button in the first element of each row.
				if (j == 0){
					myTd.innerHTML = "Click to Remove";
					myTd.onclick = function () { removeRow (theObj, this.parentNode.rowIndex); };
				}
				//Add the column to the listing.
				newTr.appendChild (myTd);
			}
		}
	}