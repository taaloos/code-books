<?php
	$_dom = new DomDocument();
	$_dom->load('exemplo.xml');	
	$_xp = new DomXPath($_dom);
	$_nos = $_xp->query("//item[position()=last()]");
	foreach($_nos as $_n) {
	   $_id = $_n->getAttribute("id");
	   echo $_n->nodeName . " id = $_id <br/>";
	 }
?>
