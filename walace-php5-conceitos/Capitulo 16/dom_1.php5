<?php
	$_dom = new DomDocument();
	$_dom->load('exemplo.xml');	 
	$_x = $_dom->getElementsByTagName("titulo");
	foreach($_x as $_no) {
	 echo $_no->nodeType . " : " . $_no->nodeName . " = " . $_no->textContent . "<br/>";
	}
?>

