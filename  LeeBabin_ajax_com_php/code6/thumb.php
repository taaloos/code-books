<?php

	//thumb.php
	
	function setWidthHeight($width, $height, $maxWidth, $maxHeight){
		$ret = array($width, $height);
		$ratio = $width / $height;
		if ($width > $maxWidth || $height > $maxHeight) {
			$ret[0] = $maxWidth;
			$ret[1] = $ret[0] / $ratio;
		
			if ($ret[1] > $maxHeight) {
				$ret[1] = $maxHeight;
				$ret[0] = $ret[1] * $ratio;
			}
		}
		return $ret;
	}

	//A function to change the size of an image.
	function createthumb ($img="", $sml="s"){
				
		//First, check for a valid file.
		if (is_file ($img)){
			
			//Now, get the current file size.
			if ($cursize = getimagesize ($img)){
			
				//Then, based on the sml variable, find the new size we want.
				$size = array("s" => 100, "m" => 300, "l" => 600);
				if (!array_key_exists($sml, $size)){
					$sml = "s";
				}
				$newsize = setWidthHeight($cursize[0], $cursize[1], $size[$sml], $size[$sml]);
				
				//Now that we have the size constraints, let's find the file type.
				$thepath = pathinfo ($img);
				//Setup our thumbnail.
				$dst = imagecreatetruecolor ($newsize[0],$newsize[1]);
				//Make a file name.
				$filename = str_replace (".".$thepath['extension'],"",$img);
				
				$types = array('jpg' => array('imagecreatefromjpeg', 'imagejpeg'), 'jpeg' => array('imagecreatefromjpeg', 'imagejpeg'), 'gif' => array('imagecreatefromgif', 'imagegif'), 'png' => array('imagecreatefrompng', 'imagepng'));
				
				$src = $types[$thepath['extension']][0] ($img);
				//Create the copy.
				imagecopyresampled ($dst,$src,0,0,0,0,$newsize[0],$newsize[1],$cursize[0],$cursize[1]);
				//Create the thumbnail.
				$types[$thepath['extension']][1] ($dst,$filename."_th".$sml.".".$thepath['extension']."");
								
				//Clear the cache.
				header("Cache-control: private, no-cache");
				header("Expires: Mon, 26 Jun 1997 05:00:00 GMT");
				header("Pragma: no-cache");
				
				//Show the img.
				?>
				<img src="<?php echo $filename; ?>_th<?php echo $sml; ?>.<?php echo strtolower($thepath['extension']); ?>" alt="" title="" style="border: none;" />
				<p>Change Image Size: <a href="thumb.php?img=<?=$img?>&amp;sml=s" onclick="changesize('<?=$img?>','s'); return false;">Small</a> | <a href="thumb.php?img=<?=$img?>&amp;sml=m" onclick="changesize('<?=$img?>','m'); return false;">Medium</a> | <a href="thumb.php?img=<?=$img?>&amp;sml=l" onclick="changesize('<?=$img?>','l'); return false;">Large</a></p>
				<?php
				
			} else {
				echo "No image found.";
			}
			
		} else {
			echo "No image found.";
		}
	}
	
	createthumb ($_GET['img'],$_GET['sml']);
?>