<?php
/**
 * Index.php5 página principal do site
 * Estrutura
 * Header->corpo->footer
 */

include_once("framework/classes/classe_html.inc");
include_once("framework/classes/classe_bancodados.inc");
include_once("framework/classes/classe_base.inc");
include_once("framework/classes/classe_menu.inc");
include_once("framework/includes/configbd.inc");
include_once("framework/classes/classe_usuario.inc");
include_once("framework/classes/classe_permissao.inc");
include_once("framework/includes/autenticacao.inc");
include_once("framework/classes/classe_barrabotoes.inc");

$_tipos = new tipospadrao();
$_main = new tag($_tipos->getTipo("HTML"));
$_main->addSubTag(new tag($_tipos->getTipo("HEAD")));
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TITLE"),null,"Sistema WEB"));
$_main->getLastSubTag()->addSubTag(new tag(new tipotag("LINK",false),
									Array(new atributo("REL","STYLESHEET"),
										  new atributo("TYPE","text/css"),
										  new atributo("HREF","framework/css/tooltips.css"))));
$_main->getLastSubTag()->addSubTag(new tag(new tipotag("LINK",false),
									Array(new atributo("REL","STYLESHEET"),
										  new atributo("TYPE","text/css"),
										  new atributo("HREF","framework/css/framework.css"))));
$_main->getLastSubTag()->addSubTag(new tag(new tipotag("LINK",false),
									Array(new atributo("REL","STYLESHEET"),
										  new atributo("TYPE","text/css"),
										  new atributo("HREF","framework/css/epoch_styles.css"))));
$_main->getLastSubTag()->addSubTag(new tag(new tipotag("LINK",false),
									Array(new atributo("REL","STYLESHEET"),
										  new atributo("TYPE","text/css"),
										  new atributo("HREF","framework/css/scriptaculous.css"))));
$_menu_css = "menu" . (strpos($_SERVER['HTTP_USER_AGENT'],'MSIE')!==false ? "_ie" : "") . ".css";
$_main->getLastSubTag()->addSubTag(new tag(new tipotag("LINK",false),
									Array(new atributo("REL","STYLESHEET"),
										  new atributo("TYPE","text/css"),
										  new atributo("HREF","framework/css/{$_menu_css}"))));
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("SCRIPT"),Array(new atributo("SRC","framework/javascript/ajax.js"))));
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("SCRIPT"),Array(new atributo("SRC","framework/javascript/processaajax.js"))));
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("SCRIPT"),Array(new atributo("SRC","framework/javascript/epoch.js"))));
$_main->getLastSubTag()->addSubTag(new tag(new tipotag("SCRIPT"),Array(new atributo("SRC","framework/javascript/scriptaculous/prototype.js"))));
$_main->getLastSubTag()->addSubTag(new tag(new tipotag("SCRIPT"),Array(new atributo("SRC","framework/javascript/scriptaculous/scriptaculous.js"))));
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("SCRIPT"),Array(new atributo("SRC","framework/javascript/funcoesgenericas.js"))));
$_main->getLastSubTag()->addSubTag(new tag(new tipotag("SCRIPT"),Array(new atributo("SRC","framework/javascript/tooltips/tooltips.js"))));
$_main->addSubTag(new tag($_tipos->getTipo("BODY"),Array(new atributo("WIDTH",1024))));
// Cabeçalho
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("DIV"),Array(new atributo("ID","HEADER"),new atributo("STYLE","color:#a0a0a0;padding:5px;"))));
$_main->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TABLE"),Array(new atributo("BODER",0))));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TR")));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),Array(new atributo("WIDTH","512px"))));
// Logo do sistema
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(
		new tag($_tipos->getTipo("A"),Array(new atributo("HREF","index.php5"),new atributo("STYLE","text-decoration:none;padding-left:0px;"),new atributo("ID","LOGO"))));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLAstSubTag()->addSubTag(
		new tag($_tipos->getTipo("IMG"),Array(new atributo("SRC","framework/imagens/logo.png"),new atributo("BORDER",0),new atributo("ALIGN","BOTTOM"))));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(
						new tag($_tipos->getTipo("TD"),Array(new atributo("ID","DATAHORA"),
															 new atributo("WIDTH","512px"),
															 new atributo("ALIGN","RIGHT"),
															 new atributo("STYLE","color:#c0c0c0;font-size:12px;vertical-align:bottom;padding-right:5px;"))));
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("SCRIPT"),null,"objDataHora.show('DATAHORA');"));
// Menu de opções
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("DIV"),Array(new atributo("ID","MENU"),
																		 new atributo("STYLE","padding:1px;padding-bottom:0px;width:1020px;" . 
																		 "border:1px solid #c0c0c0;background-color:#ece9d8"))));
$_main->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TABLE"),Array(new atributo("BODER",0))));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TR")));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
														Array(new atributo("WIDTH","604"),
															  new atributo("ALIGN","LEFT")),unserialize($_SESSION['MENU'])));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
														Array(new atributo("WIDTH","420"),
															  new atributo("ALIGN","RIGHT")),BarraPadrao::montaBarraPadrao()));
// Titulo da Página
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("DIV"),Array(new atributo("ID","TITULO"))));
// FILTRO
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("DIV"),Array(new atributo("ID","FILTRAR"),new atributo("STYLE","display:none;padding-top:5px;padding-bottom:10px;"))));
$_main->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("DIV"),Array(new atributo("ID","FILTRO"),new atributo("STYLE","background-color:#fff;border:1px Solid #aaccff;"))));
// RELATÓRIO
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("DIV"),Array(new atributo("ID","DIVRELATORIO"),new atributo("STYLE","display:none;padding-top:5px;padding-bottom:10px;"))));
$_main->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("DIV"),Array(new atributo("ID","RELATORIO"),new atributo("STYLE","background-color:#fff;border:1px Solid #aaccff;"))));
// Corpo
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("DIV"),Array(new atributo("ID","CORPO"),new atributo("STYLE","padding:1px;padding-bottom:20px;width:1024px;"))));
if($_POST['ACAO']=='SALVAR') {
	// Devemos obrigatóriamente ter o nome do script aqui
	$_file = pathinfo($_POST['SCRIPT_NAME']);
	$_HTML_RESULT = include_once($_file['basename']);
	$_main->getLastSubTag()->getLastSubTag()->AddSubTag(new tag($_tipos->getTipo('SCRIPT'),null,
										"{$_HTML_RESULT}ObjProcAjax.run('{$_POST['SCRIPT_NAME']}','CORPO');"));
} else {
	if($_COOKIE['ULTIMO_PROGRAMA']!==null) {
		$_main->getLastSubTag()->getLastSubTag()->AddSubTag(new tag($_tipos->getTipo('SCRIPT'),null,
															"ObjProcAjax.run('{$_COOKIE['ULTIMO_PROGRAMA']}','CORPO');"));
	}
}
// Rodapé
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("DIV"),Array(new atributo("ID","FOOTER"))));
$_main->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TABLE"),Array(new atributo("BODER",0))));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TR"),
														Array(new atributo("STYLE","color:#a0a0a0;padding:5px;"))));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
														Array(new atributo("WIDTH","512"),
															  new atributo("ALIGN","LEFT"))));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(
									new tag($_tipos->getTipo("IMG"),
											Array(new atributo("SRC","framework/imagens/fwphp.png"),
												  new atributo("BORDER",0),
												  new atributo("ALIGN","ABSMIDDLE"))));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(
									new tag($_tipos->getTipo("SPAN"),null,"&copy 2009 - Todos os direitos reservados"));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
														Array(new atributo("WIDTH","512"),
															  new atributo("ALIGN","RIGHT")),
														"Usuário:&nbsp;{$_SESSION['USUARIO_NOME']}&nbsp;"));
echo $_main->toHTML(false);
?>