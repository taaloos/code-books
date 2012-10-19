<?php

	//showimg.php
	
	//Check to see if the image exists.
	if (is_file ($_GET['thefile']) && file_exists ($_GET['thefile'])){
		?>
		<img src="<?=$_GET['thefile']?>" alt="" />
		<p>Change Image Size: <a href="thumb.php?img=<?=$_GET['thefile']?>&amp;sml=s" onclick="changesize('<?=$_GET['thefile']?>','s'); return false;">Small</a> | <a href="thumb.php?img=<?=$_GET['thefile']?>&amp;sml=m" onclick="changesize('<?=$_GET['thefile']?>','m'); return false;">Medium</a> | <a href="thumb.php?img=<?=$_GET['thefile']?>&amp;sml=l" onclick="changesize('<?=$_GET['thefile']?>','l'); return false;">Large</a></p>
		<?php
	}
?>