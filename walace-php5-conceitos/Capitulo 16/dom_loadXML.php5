<?php
	$_dom = new DomDocument();
	$_xml2 = 
'	<estado uf="SP">
			<cidade nome="Santo Andre">
				<bairro nome="Jardim">
					<rua>Figueiras</rua>
					<rua>Goias</rua>
					<rua>D.PedroII</rua>
				</bairro>
			</cidade>
			<cidade nome="S.Bernardo do Campo">
				<bairro nome="Parque Espacial">
					<rua>Gabriel de Souza</rua>
					<rua>Cap.Casa</rua>
				</bairro>
			</cidade>
		</estado>';

	$_dom->loadXML($_xml2);	
	echo "<pre>";
	$_dom->formatOutput = TRUE;
	echo htmlentities($_dom->saveXML());
	echo "</pre>";
?>
