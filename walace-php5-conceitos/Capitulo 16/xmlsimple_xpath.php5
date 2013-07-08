<?php
	function filhos($_no,$_n=0) {
	    	foreach($_no->children() as $_f=>$_v) {
		  		echo str_repeat("&nbsp",$_n*5);
				echo $_f . (trim($_v)!="" ? " = $_v" : "") . "<br/>";
		  		filhos($_v,$_n+1);
			}
	}
	
	$_xml = simplexml_load_file('exemplo.xml');	   
	$_criterio = "/livros//paginas";
	$_r = $_xml->xpath($_criterio);
	if($_r!==FALSE) { 		 
	    echo "Resultado de xpath($_criterio)<br/><br/>";  
		foreach($_r as $_v) {
			$_n = $_v->children();
			if(sizeof($_n[0])==0) {
				echo $_v;
			} else {
				filhos($_v);
			}
			echo "<br/>";
		}
	} else {
	   echo "Nenhuma ocorrência encontrada para $_criterio";
	}
	
	// Exemplo 2....
	$_xml2 = simplexml_load_string(
		'<estado uf="SP">
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
		</estado>');   

	echo "<pre>";
	Reflection::export(new reflectionclass($_xml2));
	echo "</pre>";			 
	
	$_criterio = "//cidade//rua";
	$_r = $_xml2->xpath($_criterio);
	if($_r!==FALSE) { 		 
	    echo "Resultado de xpath($_criterio)<br/><br/>";  
		foreach($_r as $_v) {
			$_n = $_v->children();
			if(sizeof($_n[0])==0) {
				echo $_v;
			} else {
				filhos($_v);
			}
			echo "<br/>";
		}
	} else {
	   echo "Nenhuma ocorrência encontrada para $_criterio";
	}
?>
