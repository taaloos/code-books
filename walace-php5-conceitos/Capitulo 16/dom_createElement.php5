<?php
	$_dom = new DomDocument();
	$_dom->load('exemplo.xml');	
	$_livro = $_dom->getElementsByTagName("livros");
	$_item = $_livro->item(0);
	$_x = $_dom->CreateElement("item");
	$_item->AppendChild($_x);  
	$_a = $_dom->CreateElement("autor","Mara Soares");
	$_x->AppendChild($_a);
	echo "<pre>";
	$_dom->formatOutput = TRUE;
	echo htmlentities($_dom->saveXML());
	echo "</pre>";
?>
	<?php
		$_dom = new DomDocument();
		$_livro = $_dom->createElement("livros");
		$_dom->AppendChild($_livro);
		$_item = $_dom->createElementNS("http://w3c.org/namespace","item:ts");
		$_livro->AppendChild($_item);
		$_autor = $_dom->createElement("autor","Mara Soares");
		$_item->AppendChild($_autor);
		echo "<pre>";
		$_dom->formatOutput = TRUE;
		echo htmlentities($_dom->saveXML());
		echo "</pre>";
	?>

