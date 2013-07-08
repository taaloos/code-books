<?php
	function retira_acentos($valor) {
		$char = array("ç","Ç","à","À","á","Á","ã","Ã","â","Â","è","È","é","É","ê","Ê",
     				  "ì","Ì","í","Í","î","Î","ò","Ò","ó","Ó","õ","Õ","ô","Ô",
     				  "ù","Ù","ú","Ú","û","Û");

  		$chart = array("c","C","a","A","a","A","a","A","a","A","e","E","e","E","e","E", 
     			 	   "i","I","i","I","i","I","o","O","o","O","o","O","o","O",
					   "u","U","u","U","u","U");


  		for($i=0;$i<sizeof($char);$i++) {
    		$valor = strtr($valor,$char[$i],$chart[$i]);
  		}

  		return $valor;
	}	
	
	$texto = "Esta é uma forma de retirarmos acentos do textos, por exemplo: ";
	$texto.= "ç, ã, Õ, à, ô, Á";
	echo $texto . "<br>";
	echo retira_acentos($texto);
?> 
