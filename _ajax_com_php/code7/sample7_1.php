<!-- sample7_1.php -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Sample 7_1</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="functions.js"></script>
</head>
<body>
	<h1>My Gallery</h1>
	<div style="width: 500px;">
		<!-- Big Image. -->
		<div id="middiv" style="height: 225px;">
			<?php require_once ("midpic.php"); ?>
		</div>
		<!-- Messages. -->
		<div id="errordiv"></div>
		<!-- Image navigation. -->
		<div id="picdiv"><?php require_once ("picnav.php"); ?></div>
	</div>
	<h1>Add An Image</h1>
	<form id="uploadform" action="process_upload.php" method="post" enctype="multipart/form-data" target="uploadframe">
		<input type="file" id="myfile" name="myfile" />
		<input type="submit" value="Submit" onclick="uploadimg(document.getElementById('uploadform')); return false;" />
		<iframe id="uploadframe" name="uploadframe" src="process_upload.php" class="noshow"></iframe>
	</form>
</body>
</html>