<?php
	foreach($_POST as $chave => $vlr) {
		$sql = "$chave = '" . trim($vlr) . "',";
	}
	$sql = substr($sql,-1);
	$texto = "&nbsp;Texto qualquer&nbsp;";
    $conv = html_entity_decode($texto);
    $conv = trim($conv);
	// &nbsp; foi trocado por 0xA0
	$conv = trim($conv, "\xA0");
	echo $conv;  // Veja o código fonte do HTML
?>
