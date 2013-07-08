<?php
/**
 * Index.php5 página principal do site
 * Estrutura
 * Header->corpo->footer
 */

include_once("classes/classe_html.inc");

$_tipos = new tipospadrao();
$_main = new tag($_tipos->getTipo("HTML"));
$_main->addSubTag(new tag($_tipos->getTipo("HEAD")));
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TITLE"),
null,"Sistema WEB"));
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("SCRIPT"),
Array(new atributo("SRC","javascript/ajax.js"))));
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("SCRIPT"),
Array(new atributo("SRC","javascript/processaajax.js"))));
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("SCRIPT"),
Array(new atributo("SRC","javascript/funcoesgenericas.js"))));
$_main->addSubTag(new tag($_tipos->getTipo("BODY"),
Array(new atributo("WIDTH",1024))));
// Cabeçalho
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("DIV"),
Array(new atributo("ID","HEADER"),
new atributo("STYLE","color:#a0a0a0;padding:5px;"))));
$_main->getLastSubTag()->getLastSubTag()->addSubTag(
new tag($_tipos->getTipo("TABLE"),Array(new atributo("BODER",0))));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(
new tag($_tipos->getTipo("TR")));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->
  getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
Array(new atributo("WIDTH","512"))));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->
  getLastSubTag()->addSubTag(	new tag($_tipos->getTipo("TD"),
Array(new atributo("ID","DATAHORA"),
				new atributo("WIDTH","512"),
				new atributo("ALIGN","RIGHT"),
				new atributo("STYLE","color:#c0c0c0;font-size:12px;"))));
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("SCRIPT"),
null,"objDataHora.show('DATAHORA');"));
// Menu de opções
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("DIV"),
Array(new atributo("ID","MENU"),
				 new atributo("STYLE","padding:5px;" . 
					"border:1px solid #c0c0c0;background-color:#ece9d8"))));
$_main->getLastSubTag()->getLastSubTag()->addSubTag(
new tag($_tipos->getTipo("A"),
						Array(new atributo("HREF","javascript:void(0);"),
						  	new atributo("ONCLICK",
"ObjProcAjax.run('/siteweb/exemplo_5_1.php5'," . 
"'CORPO');")),
"Exemplo 5_1"));
// Corpo
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("DIV"),
Array(new atributo("ID","CORPO"),
new atributo("STYLE","padding:5px;"))));
// Rodapé
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("DIV"),
							Array(new atributo("ID","FOOTER"),
new atributo("STYLE",
"color:#a0a0a0;padding:5px;")),
							"&copy 2009 - Todos os direitos reservados"));
echo $_main->toHTML(false);
?>
