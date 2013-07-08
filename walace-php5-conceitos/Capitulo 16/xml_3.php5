<?php
  	$_xml = simplexml_load_file('exemplo.xml');
	function filhos($_no,$_n=0) {
	    	foreach($_no->children() as $_f=>$_v) {
		  		echo str_repeat("&nbsp",$_n*5);
				echo $_f . (trim($_v)!="" ? " = $_v" : "") . "<br/>";
		  		filhos($_v,$_n+1);
			}
	}
	
	filhos($_xml);
?> 