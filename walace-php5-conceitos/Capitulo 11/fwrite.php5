<?php
	$_a = fopen("http://static.php.net/www.php.net/images/php.gif","r");
	$_d = fopen("logo_php.gif","wb+");
	if($_a!==FALSE) {
		while(!feof($_a)) {
	  		fwrite($_d,fgets($_a,4096),4096);
		}
	}
	fclose($_a);
	fclose($_d);
	$_a = fopen("http://www.mysql.com/common/img/mysql.png","r");
	$_d = fopen("logo_mysql.png","wb+");
	if($_a!==FALSE) {
		while(!feof($_a)) {
	  		fwrite($_d,fgets($_a,4096),4096);
		}
	}
	fclose($_a);
	
?>
<html>
<head>
	<title>PH5</title>
</head>
<body>
<p><img src="logo_php.gif"><img src="logo_mysql.png"></p>
</body>
</hrml>
