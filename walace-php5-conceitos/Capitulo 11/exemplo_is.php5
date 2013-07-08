<?php
   function detalhe($_arq) {
	   if(is_file($_arq)) {
	     $_ret.= "<td>Arquivo</td>";
         $_ret.= "<td>" . (is_link($_arq) ? "*" : "-") . "</td>";
		 $_ret.= "<td>" . (is_executable($_arq) ? "*" : "-") . "</td>";
         $_ret.= "<td>" . (is_readable($_arq) ? "*" : "-") . "</td>";
         $_ret.= "<td>" . (is_writable($_arq) ? "*" : "-") . "</td>";
		 return $_ret;
	   }
	   else {
	     return "<td><b>Diretório</b></td><td>-</td><td>-</td><td>-</td><td>-</td>";
	   }
   }

   function le_diretorio($_dir) {
      $_ret = "<table border=1 cellpadding=2>\n";
	  $_ret.= "<tr><td><b>Arquivo</td>";
	  $_ret.= "<td>Tipo</td>";
	  $_ret.= "<td>Link Simbólico</td>";
	  $_ret.= "<td>Executável</td>";
	  $_ret.= "<td>Permissão leitura</td>";
	  $_ret.= "<td>Permissão escrita</td>";
	  $_ret.= "</tr>";
	  foreach(scandir($_dir) as $_arq) {
  		if(substr($_arq,0,1)=="." AND strlen($_arq)<=2) {
	 		continue;
	  	}
		$_ret.= "<tr align='center'><td align='left'>$_dir\\$_arq</td>" . detalhe("$_dir/$_arq") . "</tr>\n";
	  }
	 $_ret.= "</table>\n";
	 echo $_ret;
   }
		
   le_diretorio("c:\\PHP");
		
?>
		
