<?php
	include_once("class_HTML.inc");

	$_html = new HTML();
	$_id[0] = $_html->AddTag("HTML");
	$_html->AddTag("TITLE",NULL,TRUE,"PHP5 - Editora Érica");
	$_id[1] = $_html->AddTag("BODY");
	$_id[2] = $_html->AddTag("SCRIPT");
	$_html->AddText($_id[2],"alert('Data/Hora Atual: " .
							date("d-m-Y H:i:s") . "');");		
	$_html->EndTag($_id[2]);
	$_html->EndTag($_id[1]);
	$_html->EndTag($_id[0]);
	echo $_html->toHTML();
?>
