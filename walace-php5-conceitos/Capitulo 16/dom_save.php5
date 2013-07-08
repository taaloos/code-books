<?php
	$_dom = new DomDocument();
	$_dom->load('exemplo.xml');	
	
	// Alterar o documento
	function altera_no($_no,$_novo,$_satt,$_svlr,$_exc=FALSE,$_inc=FALSE) {
		static $_ok=FALSE;
		foreach($_no->childNodes as $_filho) {
			if($_ok==TRUE&&$_filho->nodeName==$_novo->nodeName) { 
				if($_exc===TRUE) {
					$_no->removeChild($_filho);
				} else {
					$_no->replaceChild($_novo,$_filho);
				}
				$_ok=FALSE;
				return TRUE;
			}
			if($_filho->hasAttributes()) {
					foreach($_filho->attributes as $_att) {
						if($_att->nodeName==$_satt && $_att->textContent==$_svlr) {
							if($_inc===TRUE) {
								$_filho->appendChild($_novo);
								return TRUE;
							}
							$_ok=TRUE;
						}
					}
			}
			if($_filho->nodeType!=3) {
				$_r = altera_no($_filho,$_novo,$_satt,$_svlr,$_exc,$_inc);
				if($_r===TRUE) {
					return TRUE;
				}
			}
		}
	}
	
	$_novo = $_dom->createElement("data","Maio/2001");
	altera_no($_dom,$_novo,"id","0002");
	$_novo = $_dom->createElement("paginas","999");
	altera_no($_dom,$_novo,"id","0002"); 
	
	$_novo = $_dom->createElement("isbn");
	altera_no($_dom,$_novo,"id","0002",TRUE); 	
	
	$_novo = $_dom->createElement("isbn","0521785197");
	if(altera_no($_dom,$_novo,"id","0001",FALSE,TRUE)) {
		$_novo->setAttribute("tipo","A"); 	
		$_novo->setAttribute("ordem","1"); 			
		$_novo->removeAttribute("tipo");
	}	

	$_livro = $_dom->getElementsByTagName("livros");
	$_item = $_livro->item(0);
	$_item->setAttribute("version","1.2");

	$_dom->save("exemplo_2.xml");
	 
	echo "<pre>";
	$_dom->formatOutput = TRUE;
	echo htmlentities($_dom->saveXML());
	echo "</pre>";
	
?>
