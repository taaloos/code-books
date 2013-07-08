<?php
  function gera_senha($_tsenha=8) {
     if($_tsenha<=0) return FALSE;
	 $_llcase = array("a","b","c","d","e","f","g","h",
                     "i","j","k","l","m","n","o","p","q",
                     "r","s","t","u","v","w","x","y","z");
     $_lucase = array("A","B","C","D","E","F","G","H",
                      "J","K","L","M","N","P","Q",
                      "R","S","T","U","V","W","X","Y","Z");
     $_num 	  = array("0","1","2","3","4","5","6","7","8","9");
     $_scar   = array("!","#","%","@","*","&");
	 $_tipos  = Array("L","U","N","S");
	 $_senha  = ""; 
	 for($_i=0;$_i<$_tsenha;$_i++) {
	    $_t = array_rand($_tipos);
		switch ($_tipos[$_t]) {
		 case 'L': $_c = $_llcase[array_rand($_llcase)];
		 	  	   break;
		 case 'U': $_c = $_lucase[array_rand($_lucase)];
		 	  	   break;
		 case 'N': $_c = $_num[array_rand($_num)];
		 	  	   break;
		 case 'S': $_c = $_scar[array_rand($_scar)];
		 	  	   break;
		}
		$_senha .= $_c;	   
	 }
	 
	 return $_senha;
  }

  echo gera_senha() . "<br/>";
  echo gera_senha(4) . "<br/>";
  echo gera_senha(15) . "<br/>";
  echo gera_senha(32) . "<br/>";  
  echo gera_senha(9) . "<br/>";  
?>