<?php
	//process_upload.php

	//Allowed file mime types.
	$allowedtypes = array ("image/jpeg","image/pjpeg","image/png","image/gif");
	//Where we want to save the file to.
	$savefolder = "images";
	
	/*
	//First, kill off all older files.
	if (is_dir ($savefolder)){
		$scanarray = scandir ($savefolder);	
		$numdirs = count ($scanarray);	
		//parse the array
		for ($i = 0; $i < $numdirs; $i++){
			// make sure it is not the '.' or '..' files
			if ($scanarray[$i] != "." && $scanarray[$i] !="..") {
				//make sure it's a file
				if (is_file ($savefolder . "/" . $scanarray[$i])){
					unlink ($savefolder . "/" . $scanarray[$i]);
				}	
			}
		}
	}
	*/

	//If we have a valid file.
	if (isset ($_FILES['myfile'])){
		//Then we need to confirm it is of a file type we want.
		if (in_array ($_FILES['myfile']['type'],$allowedtypes)){
			//Then we can perform the copy.
			if ($_FILES['myfile']['error'] == 0){
				$thefile = $savefolder . "/" . $_FILES['myfile']['name'];
				if (!move_uploaded_file ($_FILES['myfile']['tmp_name'], $thefile)){
					echo "There was an error uploading the file.";
				} else {
					//Signal the parent to load the image.
					?>
					<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<script type="text/javascript" src="functions.js"></script>
					</head>
					<body>
						<img src="<?=$thefile?>" onload="doneloading (parent,'<?=$thefile?>')" />
					</body>
					</html>
					<?php
				}
			}
		}
	}
?>