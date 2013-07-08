<?php
	$_f = "musica.wma"; // Arquivo que será enviado
	$_s = 8.5; // 8,5 kb/s
	if(file_exists($_f) && is_file($_f)) {
		header("Content-Description: File Transfer");
		header("Content-Type: application/force-download");
  		header("Content-Length: ".filesize($_f));
 	 	header("Content-Disposition: filename=$_f" . "%20"); 
  		flush();
  		$_fd = fopen($_f, "rb");
		$_t = round($_s*1024);
  		while(!feof($_fd)) {
        	echo fread($_fd, $_t);
      		flush();
			sleep(1);
         }
  		fclose ($fd);
	}
	else {
	  echo "$_f  não existe...";
	}
	  
?>
