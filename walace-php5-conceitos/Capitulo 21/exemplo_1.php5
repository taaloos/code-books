<?php
	include_once("class_HTML.inc");

	$_html = new HTML();
	$_id[0] = $_html->AddTag("HTML");
	$_html->AddTag("TITLE",NULL,TRUE,"PHP5 - Editora Érica");
	$_id[1] = $_html->AddTag("BODY");
	$_html->AddTag("P",NULL,TRUE,"Hoje é " . date("d-m-Y") );
	$_html->EndTag($_id[1]);
	$_html->EndTag($_id[0]);
	echo $_html->toHTML();
?>
