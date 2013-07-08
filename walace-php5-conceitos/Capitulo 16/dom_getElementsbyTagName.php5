<?php
	$_dom = new DomDocument();
	$_dom->load('exemplo.xml');	

	echo "exemplo 1:<br/>";
	$_items = $_dom->getElementsByTagName("titulo");
	foreach($_items as $_no) {
	 echo $_no->nodeType . " : " . $_no->nodeName . " = " . $_no->textContent . "<br/>";
	}

	echo "<br/>";
	
	echo "exemplo 2:<br/>";
	$_res = $_dom->getElementsByTagName("item");
	$_item = $_res->item(0);
	foreach($_item->childNodes as $_no) {
			if($_no->nodeType==1) {
  				echo $_no->nodeName . " = " . $_no->textContent . "<br/>";
			}
	}
?>
