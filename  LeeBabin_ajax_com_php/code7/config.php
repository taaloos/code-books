<?php

	//config.php

	//Configuration.
	//The max to create the thumbnails.
	$GLOBALS['maxwidth'] = 500;
	//The max height to create the thumbnails.
	$GLOBALS['maxheight'] = 200;
	//The maximum width of the generated thumbnails.
	$GLOBALS['maxwidththumb'] = 60;
	//The maximum height of the generated thumbnails.
	$GLOBALS['maxheightthumb'] = 60;
	//Where to store the images.
	$GLOBALS['imagesfolder'] = "images";
	//Where to create the thumbs.
	$GLOBALS['thumbsfolder'] = "images/thumbs";
	//Allowed file types.
	$GLOBALS['allowedfiletypes'] = array ("jpg","jpeg","gif","png");
	//Allowed file mime types.
	$GLOBALS['allowedmimetypes'] = array ("image/jpeg","image/pjpeg","image/png","image/gif");
	//Number of images per row in the navigation.
	$GLOBALS['maxperrow'] = 7;
?>