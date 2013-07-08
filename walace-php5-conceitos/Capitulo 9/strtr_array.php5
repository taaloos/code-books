<?php
	function retira_acentos($valor) {
		$char = array("ç" => "c","Ç" => "C","à" => "a","À" => "A",
		              "á" => "a","Á" => "A","ã" => "a","Ã" => "A",
					  "â" => "a","Â" => "A","è" => "e","È" => "E",
					  "é" => "e","É" => "E","ê" => "e","Ê" => "E",
     				  "ì" => "i","Ì" => "I","í" => "i","Í" => "I",
					  "î" => "i","Î" => "I","ò" => "o","Ò" => "O",
					  "ó" => "o","Ó" => "O","õ" => "o","Õ" => "O",
					  "ô" => "o","Ô" => "O","ù" => "u","Ù" => "U",
					  "ú" => "u","Ú" => "U","û" => "u","Û" => "U");

  		return strtr($valor,$char);
	}	
	
	$texto = "Esta é uma forma de retirarmos acentos do textos, por exemplo: ";
	$texto.= "ç, ã, Õ, à, ô, Á";
	echo $texto . "<br>";
	echo retira_acentos($texto);
?> 
