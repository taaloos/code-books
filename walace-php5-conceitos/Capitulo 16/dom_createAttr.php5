	<?php
		$_dom = new DomDocument();
		$_livro = $_dom->createElement("livros");
		$_dom->AppendChild($_livro);
	 	$_item = $_dom->createElement("item");
		$_livro->AppendChild($_item);
		$_att = $_dom->createAttribute("id");
		$_item->AppendChild($_att);
		$_texto = $_dom->createTextNode("1000");
		$_att->appendChild($_texto);
		$_att = $_dom->createAttribute("data");
		$_item->AppendChild($_att);
		$_texto = $_dom->createTextNode(date("d-m-Y H:i:s"));
		$_att->appendChild($_texto);
		$_autor = $_dom->createElement("autor","Mara Soares");
		$_item->AppendChild($_autor);
		echo "<pre>";
		$_dom->formatOutput = TRUE;
		echo htmlentities($_dom->saveXML());
		echo "</pre>";
	?>
