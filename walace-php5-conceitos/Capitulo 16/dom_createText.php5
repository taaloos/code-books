<?php
	$_dom = new DomDocument();
	$_livro = $_dom->createElement("livros");
	$_dom->AppendChild($_livro);
 	$_item = $_dom->createElement("item");
	$_livro->AppendChild($_item);
	$_autor = $_dom->createElement("autor");
	$_item->AppendChild($_autor);
	$_texto = $_dom->createTextNode("Mara Soares");
	$_autor->AppendChild($_texto);
	echo "<pre>";
	$_dom->formatOutput = TRUE;
	echo htmlentities($_dom->saveXML());
	echo "</pre>";
?>
