<?php
	function lista_dir($_dir,$_nivel=0) {
	   if(!is_dir($_dir)) {
	      return FALSE;
	   }
	   $_od = getcwd();
	   echo str_repeat("&nbsp;",$_nivel*5) . 
		  	"<img src='folder.png' border=0 align='absmiddle'> " .  
			$_dir . "<br/>";
	   chdir($_dir);
	   $_d = @opendir("./");
	   while (($_l=readdir($_d))!==FALSE) {
		  if(substr($_l,0,1)=="." AND strlen($_l)<=2) {
 			 continue;
		  }
		  if(is_dir($_l)) { 
		    lista_dir($_l,$_nivel+1);
		  }
		  else {
		    echo str_repeat("&nbsp;",($_nivel+1)*5) . "- " . $_l . "<br/>";
		  }
	   }
	   closedir($_d);
	   chdir($_od);
	}
	
	lista_dir("c:\\PHP\\");
?>


