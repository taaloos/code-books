<?php

	//delpic.php

	//Check for a valid image.
	if (is_file ($_GET['pic'])){
		//Attempt to remove the image.
		if (unlink ($_GET['pic'])){
			?>
			<div style="background: #EEEEEE; width: 100%;">
				<div style="padding: 4px; color: #32CD32;">
					Image successfully removed.
				</div>
			</div>
			<?php
		} else {
			?>
			<div style="background: #EEEEEE; width: 100%;">
				<div style="padding: 4px; color: #FF0000;">
					Image could not be removed.
				</div>
			</div>
			<?php
		}
	}
?>