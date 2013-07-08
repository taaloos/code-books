<?php
	require_once("class_bd.inc");
	require_once("class_HTML.inc");
	
	
	$_con = new consulta("postgresql");
	$_con->SetBD("BD_PHP5");		   
	$_con->SetServidor("192.168.0.64");
	$_con->SetUsuario("postgres");
	
	$_con->conecta();
	
	$_con->setSQL("SELECT userid, userLogin, userName, userEmail FROM Usuario ORDER BY userName");
	$_con->executa(); 

	$_lbl = Array("Código","Login","Nome","Email");										  
	
	$_html = new HTML();
	$_ihtml = $_html->AddTag("HTML");
	$_ihead = $_html->AddTag("HEAD",NULL);
	$_html->AddTag("TITLE",NULL,TRUE,"PHP5 - Walace Soares");
	$_html->EndTag($_ihead);
	$_ib = $_html->AddTag("BODY");
	
	$_tab = new TABELA();  
	$_tab->setCorFundoHeader("Navy");
	$_tab->setCorFonteHeader("white");
	$_tab->AddHeader($_lbl);					
	$_tab->setCorFundoDetalhe("#ffffcc");
	$_tab->setExtras("border: 1px solid Navy;");
	while(($_dados=$_con->getDados())!==FALSE) {
		$_tab->AddDetalhe($_dados);
		if($_tab->getCorFundoDetalhe()=="#ffffcc") {
			$_tab->setCorFundoDetalhe("#ffffff");
		} else {
			$_tab->setCorFundoDetalhe("#ffffcc");
		}
	}
	
	$_tab->setCorFundoHeader("#ffffff");
	$_tab->setCorFonteHeader("Brown");
	$_tab->setExtras("font-size: 11px;");
	$_tab->setFonte("Arial");											
	$_tab->AddFooter("{$_con->getNumRows()} registros",TRUE);
	
	$_tab->close();
	
	$_html->AddText($_ib,$_tab->toHTML());
	$_html->EndTag($_ib);
	$_html->EndTag($_ihtml);
	echo $_html->toHTML();
	
	$_con->close();
?>