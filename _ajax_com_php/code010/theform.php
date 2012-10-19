<?php
	//theform.php
	
	//Check for incoming messages.
	if (isset ($_GET['message'])){
		?>
		<div class="themessage">
			<?php echo urldecode (stripslashes ($_GET['message'])); ?>
		</div>
		<?php
	}
	
	?>
	<p>Add a New Location:</p>
	<form id="newloc" name="newloc" method="post" onsubmit="submitform (document.getElementById('newloc'),'process_form.php','createloc',validateloc); return false;">
		<input type="text" name="busname" maxlength="150" value="-- name --" onfocus="this.value=''" /><br />
		<input type="text" name="address" maxlength="150" value="-- address --" onfocus="this.value=''" class="marginspace" /><br />
		<input type="text" name="city" maxlength="150" value="-- city --" onfocus="this.value=''" class="marginspace" /> <input type="text" name="province" maxlength="150" value="-- province --" onfocus="this.value=''" class="marginspace" /><br />
		<input type="text" name="postal" maxlength="150" value="-- postal --" onfocus="this.value=''" class="marginspace" /><br />
		<p class="marginspace">Latitude/Longitude</p>
		<input type="text" name="latitude" maxlength="150" value="-- latitude --" onfocus="this.value=''" /> <input type="text" name="longitude" maxlength="150" value="-- longitude --" onfocus="this.value=''" /><br />
		<input type="submit" value="add location" class="marginspace" />
	</form>
	<?php
?>