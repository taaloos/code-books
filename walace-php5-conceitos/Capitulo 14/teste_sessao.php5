<?php
	// TESTE de Sessão...
	
	include_once("class_sessao.inc");
	
	$_a = Array("Codigo"=>100,"Valor"=>2500,"Tipo"=>10);
	
	$_s = new sessao(TRUE);
	if($_s->getNVars()>0) {
	   	$_s->setVars("Codigo",$_s->getVars("Codigo")+10);
		$_s->setVars("Valor",$_s->getVars("Valor")*1.25);
		//$_s->unSetVars("Tipo");
	} else {
	  	$_s->setVars($_a);
	}
	//echo "TOTAL:" . $_s->getNVars() . "....AQUI: " . $_s->getVars("Codigo");	
	//echo $_SESSION["Codigo"];												  
	$_s->printAll();
	//$_s->destroy();
?>