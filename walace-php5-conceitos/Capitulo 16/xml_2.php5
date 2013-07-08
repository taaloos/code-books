<?php
	$_dxml = new DOMDocument('1.0');
	$_livros = $_dxml->createElement('livros');
	$_livros = $_dxml->appendChild($_livros);
	$_item = $_dxml->createElement('item');
	$_item = $_livros->appendChild($_item);
	$_titulo = $_dxml->createElement('titulo');
	$_titulo = $_item->appendChild($_titulo);
	$_texto = $_dxml->createTextNode('PHP 5');
	$_texto = $_titulo->appendChild($_texto);
	$_autor = $_dxml->createElement('autor');
	$_autor = $_item->appendChild($_autor);
	$_texto = $_dxml->createTextNode('Walace Soares');
	$_texto = $_autor->appendChild($_texto);
	
	echo "<pre>";
	$_dxml->formatOutput = TRUE;
	echo htmlentities($_dxml->saveXML());
	echo "</pre>";
	
	$_xml = simplexml_import_dom($_dxml);
	
	echo "<pre>";
  	var_dump($_xml);
	echo "</pre>";
?>
 