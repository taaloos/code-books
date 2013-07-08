<!-- process_upload.php -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Upload</title></head>
<body>
	<?php
	
		require_once ("config.php");
		require_once ("functions.php");
	
		//If we have a valid file.
		if (isset ($_FILES['myfile'])){
			if ($_FILES['myfile']['error'] == 0){
				//Then we need to confirm it is of a file type we want.
				if (in_array ($_FILES['myfile']['type'],$GLOBALS['allowedmimetypes'])){
					//Then we can perform the copy.
					if (!move_uploaded_file ($_FILES['myfile']['tmp_name'], $GLOBALS['imagesfolder'] . "/" . $_FILES['myfile']['name'])){
						echo "There was an error uploading the file.";
					}
				}
			} else {
				echo "There is an error with the file.";
			}
		}
	?>
</body>
</html>