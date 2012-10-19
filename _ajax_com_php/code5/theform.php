<?php 
	//theform.php
?>
<div style="padding: 10px;">
	<div id="themessage">
		<?php
			if (isset ($_GET['message'])){
				echo $_GET['message'];
			}
		?>
	</div>
	<form action="process_task.php" method="post" id="newtask" name="newtask">
		Your Name<br />
		<input name="yourname" id="yourname" style="width: 150px; height: 16px;" type="text" value="" onkeypress="autocomplete(this.value, event)" /><br />
		Your Task<br />
		<textarea style="height: 80px;" name="yourtask" id="yourtask"></textarea><br />
		<input type="hidden" name="thedate" value="<?php echo $_GET['thedate']; ?>" />
		<input type="button" value="Submit" onclick="submitform (document.getElementById('newtask'),'process_task.php','createtask',validatetask); return false;" />
		<div align="right"><a href="javascript:closetask()">close</a></div>
	</form>
</div>