<?php
	include_once("class_HTML.inc");
	include_once("class_bd.inc");
	
	$_con = new consulta("mysqli");	 
	$_con->setBD("BD_PHP5");
	$_con->conecta();
	$_con->setSQL("SELECT userId, userLogin, userName, userEmail FROM Usuario ORDER BY userName");
	$_con->executa();

	$_html = new HTML();
	$_id[0] = $_html->AddTag("HTML");
	$_html->AddTag("TITLE",NULL,TRUE,"PHP5 - Editora Érica");
	$_id[1] = $_html->AddTag("BODY");
	$_html->AddTag("P",NULL,TRUE,"<b>Relação de Usuários</b>");
	$_id[2] = $_html->AddTag("TABLE",Array(	"border"=>0,
							  		 	   	"cellspacing"=>0,
				  		    				"cellpadding"=>2,
										  	"width"=>"600",
										  	"valign"=>"top")
						 	);
	$_id[3] = $_html->AddTag("TR",Array("style"=>"background-color:Navy;color:White"));
	$_html->AddTag("TD",NULL,TRUE,"Código");
	$_html->AddTag("TD",NULL,TRUE,"Login");	
	$_html->AddTag("TD",NULL,TRUE,"Nome do Usuário");
	$_html->AddTag("TD",NULL,TRUE,"E-mail");
	$_html->EndTag($_id[3]);			  
	$_cor = "#ffffff";
	while(($_dados=$_con->getDados())!==FALSE) {
		$_id[3] = $_html->AddTag("TR",Array("bgcolor"=>$_cor));
		$_html->AddTag("TD",NULL,TRUE,$_dados["userId"]);
		$_html->AddTag("TD",NULL,TRUE,$_dados["userLogin"]);	
		$_html->AddTag("TD",NULL,TRUE,$_dados["userName"]);
		$_html->AddTag("TD",NULL,TRUE,$_dados["userEmail"]);
		$_html->EndTag($_id[3]);
		$_cor = ($_cor=="#ffffff" ? "#d0d0d0" : "#ffffff");
	}					 
	$_html->EndTag($_id[2]);
	$_html->AddTag("P",Array("style"=>"font-size:9px;color: Navy;"),TRUE,"Total de {$_con->getNumRows()} Usuários");
	$_html->EndTag($_id[1]);
	$_html->EndTag($_id[0]);
	echo $_html->toHTML();
?>
