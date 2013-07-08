<?php
	$_xml = simplexml_load_file('exemplo.xml');	   
	echo "<pre>";
	echo htmlentities($_xml->asXML());
	$_xml->asXML('t.xml');
	echo "</pre>";
?>
