<?php
	function copy_dir($_s_dir,$_d_dir) {
   		if(!is_dir($_s_dir)) {
			echo "X";
      		return FALSE;
   		}
   		$_od = getcwd(); // Devemos guardar o diretório atual...
   		chdir($_s_dir);
   		$_d = @opendir("./");
		$_ret = TRUE;
  		while (($_l=readdir($_d))!==FALSE) {
	  		If(substr($_l,0,1)=="." AND strlen($_l)<=2) {
			 		continue;
	  		}
	  		if(is_dir($_l)) { 
				mkdir("$_d_dir/$_l");
				if(!copy_dir("$_s_dir/$_l","$_d_dir/$_l"))
				   $_ret = FALSE;
	  		}
	  		else {
				if(!copy($_l,"$_d_dir/$_l")) {
				   echo "$_l <br/>";
				   $_ret = FALSE;
				}
	  		}
   		}
   		closedir($_d);
   		chdir($_od);
		return $_ret;
	}
	var_Dump(copy_dir("c:\\PHP\\","C:\\TEMP\PHP5"));	  // Exemplo...
?>
