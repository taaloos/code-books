<?php

	//midpic.php

	require_once ("config.php");
	require_once ("functions.php");
	
	//Find how many images are in the images directory.
	$imgarr = getImages();
	$totimages = getImageCount($imgarr);
	
	//Check if we have any images in our gallery.
	if ($totimages > 0){
		if (!isset ($_GET['curimage']) && $_GET['curimage'] == ""){
			//Default to the first.
			$_GET['curimage'] = getImageAtIndex ($imgarr, 0);
		}
		//Show the big img.
		if (is_file ($GLOBALS['imagesfolder'] . "/" . $_GET['curimage'])){
			//Create a smaller version in case of huge uploads.
			$thumb = createthumb ($_GET['curimage'],$GLOBALS['maxwidth'],$GLOBALS['maxheight'],"_big");
			if (is_file ($thumb) && file_exists ($thumb)){
				if ($size = getimagesize ($thumb)){
					?>
					<div style="text-align: center; margin-top: 10px; margin-bottom: 10px;">
						<img src="<?php echo $GLOBALS['imagesfolder'] . "/" . $_GET['curimage']; ?>" alt="" title="" style="width: <?php echo $size[0]; ?>px; height: <?php echo $size[1]; ?>px;" />
					</div>
					<!-- Remove navigation. -->
					<div style="text-align: right;">
						<a href="javascript://" onclick="removeimg ('<?php echo $GLOBALS['imagesfolder'] . "/" . $_GET['curimage']; ?>')"><img src="delete.png" alt="remove image" title="remove image" style="border: none;" /></a>
					</div>
					<?php
				}
			}
		}
	} else {
		echo "Gallery is empty.";
	}
?>