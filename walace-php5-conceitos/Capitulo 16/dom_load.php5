<?php
	$_dom = new DomDocument();
	$_dom->load('exemplo.xml');
	echo "<pre>";
	$_dom->formatOutput = TRUE;
	echo htmlentities($_dom->saveXML());
	echo "</pre>";
?>
