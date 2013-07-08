<?php
	$_dom = new DomDocument();
	$_dom->load('exemplo.xml');	
	
	function nos($_no,$_n=0) {	 
		foreach($_no->childNodes as $_filho) {
			$_ex = "";
			if($_filho->nodeType!=3) {
				if($_n!=0) { echo "<br/>";}
				echo str_repeat("&nbsp;",$_n*5);
				echo "{$_filho->nodeName}";	 
				if($_filho->hasAttributes()) {	
					foreach($_filho->attributes as $_att) {
						echo " ({$_att->nodeName} = {$_att->textContent}) ";
					}
				}
			}
			if($_no->nodeType==1 AND $_filho->nodeType==3) { 
				if(trim($_filho->textContent)!="") {
					echo " = " . trim($_filho->textContent);
				}
			} else {  
				nos($_filho,$_n+1);	
			}
		}
	}
	
	nos($_dom);
?>
