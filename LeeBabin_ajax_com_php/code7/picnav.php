<?php

	//picnav.php

	require_once ("config.php");
	require_once ("functions.php");
					
	//Find a total amount of images.
	$imgarr = getImages();
	$totcounter = getImageCount($imgarr);
		
	//If there is more than one image.
	if ($totcounter > 0){
		?>
		<table style="margin-top: 10px; width: 100%; border: none; background: #F2F2F5; height: 60px; border-style: solid; border-color: #000000; border-width: 1px;" cellpadding="0" cellspacing="0">
			<tr>
			<?php
				$idarr = array ();
				if (!isset ($_GET['curimage']) && $_GET['curimage'] == ""){
					//Call the retrieve image function.
					$_GET['curimage'] = getImageAtIndex ($imgarr, 0);
				}
				//Figure out where to start from and where to end.
				//Run through and figure it out.
				if (is_dir ($GLOBALS['imagesfolder'])){
					$mydir = scandir ($GLOBALS['imagesfolder']);
					//Loop through and find any valid images.
					$counter = 1;
					for ($i = 0; $i < count ($mydir); $i++){
						//Ignore directory dots.
						if ($mydir[$i] != "." && $mydir[$i] !="..") {
							//make sure it's a file
							if (is_file ($imagesfolder . "/" . $mydir[$i])){
								//Check for a valid file type.
								$thepath = pathinfo ($GLOBALS['imagesfolder'] . "/" . $mydir[$i]);
								if (in_array ($thepath['extension'], $GLOBALS['allowedfiletypes'])){
									//If we have the match.
									if ($_GET['curimage'] == $mydir[$i]){
										//Find the start position.
										$startfrom = ($counter - floor ($GLOBALS['maxperrow'] / 2));
										
										//If startfrom is less than 1, it should be defaulted to 1.
										if ($startfrom < 1){
											$startfrom = 1;
										}
										
										//Now, if there are less images showing than there should be.
										if (($totcounter - $startfrom) < $GLOBALS['maxperrow']){
											//Find out how much over it is.
											$diff = $GLOBALS['maxperrow'] - ($totcounter - $startfrom);
											$startfrom = (($startfrom - $diff) + 1);
										}
										
										//If startfrom is less than 1, it should be defaulted to 1.
										if ($startfrom < 1){
											$startfrom = 1;
										}
									}
									$counter++;
								}
							}	
						}
					}
				}
				
				//Now, run through and grab from startfrom to endat.
				if (is_dir ($GLOBALS['imagesfolder'])){
					$mydir = scandir ($GLOBALS['imagesfolder']);
					//Loop through and find any valid images.
					$counter = 1;
					//Counter to determine if we have shown enough images.
					$numshown = 0;
					for ($i = 0; $i < count ($mydir); $i++){
						//Ignore directory dots.
						if ($mydir[$i] != "." && $mydir[$i] !="..") {
							//make sure it's a file
							if (is_file ($imagesfolder . "/" . $mydir[$i])){
								//Check for a valid file type.
								$thepath = pathinfo ($GLOBALS['imagesfolder'] . "/" . $mydir[$i]);
								if (in_array ($thepath['extension'], $GLOBALS['allowedfiletypes'])){
									//If we have the match.
									if ($counter >= $startfrom){
										if ($numshown < $GLOBALS['maxperrow']){
											$idarr[] = $mydir[$i];
											$numshown++;
										}
									}
									$counter++;
								}
							}	
						}
					}
				}
				
				for ($i = 0; $i < count ($idarr); $i++){
					?>
					<td style="width: <?php echo intval (100 / count ($idarr)); ?>%; text-align: center; vertical-align: middle;<?php if ($_GET['curimage'] == $idarr[$i]){?> background: #CCCCCC;<?php } ?>">
						<?php
							if (is_file ($GLOBALS['imagesfolder'] . "/" . $idarr[$i])){
								$thumb = createthumb ($idarr[$i],$GLOBALS['maxwidththumb'],$GLOBALS['maxheightthumb'],"_th");
								if (is_file ($thumb) && file_exists ($thumb)){
									if ($size = getimagesize ($thumb)){
										?>
										<div style="text-align: center;">
											<a href="javascript://" onclick="clearmes(); showload(); runajax ('middiv','midpic.php?curimage=<?php echo $idarr[$i]; ?>'); runajax ('picdiv','picnav.php?curimage=<?php echo $idarr[$i]; ?>');"><img<?php if ($_GET['curimage'] != $idarr[$i]){?> onmouseover="this.className='fimghover'" onmouseout="this.className='fimgoff'"<?php } ?> src="<?php echo $thumb; ?>" class="fimg<?php if ($_GET['curimage'] == $idarr[$i]){?>hoveryellow<?php } else {?>off<?php } ?>" alt="" title="" style="width: <?php echo $size[0]; ?>px; height: <?php echo $size[1]; ?>px;" /></a>
										</div>
										<?php
									}
								}
							}
						?>
					</td>
					<?php
				}
			?>
			</tr>
		</table>
		<?php
	}
?>