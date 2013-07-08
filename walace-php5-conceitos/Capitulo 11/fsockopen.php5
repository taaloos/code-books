<?php
   function valida_url($_h,$_pagina="/",$_p=80) {
       if (empty( $_p)) $_p = "80";
       $socket = @fsockopen( $_h, $_p, $_e, $_estr);
       if (!$socket)
       {
           return(false);
       }
       else
       {
	   		if($_pagina=="") {
				$_pagina = "/";
			}
           	fwrite ($socket, "HEAD $_pagina HTTP/1.0\r\nHost: $_h\r\n\r\n");
           	$http_response = fgets( $socket,1024);
           	if ( ereg("200 OK", $http_response, $regs)) {
               return TRUE;
               fclose($socket);
           	} else {
               return "Resposta: $http_response<br>";
           	}
       }
   }
   
   $_r = valida_url("www.zanthus.com.br","/valida_senha.asp");
   if($_r===TRUE) {
   		echo "OK";
	}
	else {
		echo $_r;
	}
		
?> 
