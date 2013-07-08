<?php
	include_once("class_HTML.inc");
	include_once("class_bd.inc");
	
	$_con = new consulta("mysqli");	 
	$_con->setBD("BD_PHP5");
	$_con->conecta();
	$_con->setSQL("SELECT userId, userLogin, userName, userEmail FROM Usuario ORDER BY userName");
	$_con->executa();

	$_html = new TABELA(FALSE);
	$_id[0] = $_html->AddTag("HTML");
	$_html->AddTag("TITLE",NULL,TRUE,"PHP5 - Editora Érica");
	$_id[1] = $_html->AddTag("BODY");
	$_html->AddTag("P",NULL,TRUE,"<b>Relação de Usuários</b>");
	$_html->AddTabela("600");
	$_html->SetCorFundoHeader("Navy");
	$_html->SetCorFonteHeader("White");
	$_html->AddHeader(Array("Código","Login","Nome do Usuário","E-mail"));
	$_html->SetCorFundoDetalhe("#FFFFFF");	   
	$_html->SetExtras("border-bottom: 1px solid #c0c0c0;");
	while(($_dados=$_con->getDados())!==FALSE) {
		$_html->AddDetalhe($_dados);
		if($_html->GetCorFundoDetalhe()=="#FFFFFF") {
			$_html->SetCorFundoDetalhe("#ffffcc");
		} else {
			$_html->SetCorFundoDetalhe("#FFFFFF");
		}
	}		
	$_html->SetCorFundoHeader("#ffffff");
	$_html->SetCorFonteHeader("brown");
	$_html->SetExtras("font-size: 9px; height: 25;");	
	$_html->AddFooter("Total de {$_con->getNumRows()} Usuários",0,TRUE);
	$_html->close();
	$_html->EndTag($_id[1]);
	$_html->EndTag($_id[0]);
	echo $_html->toHTML();
?>
