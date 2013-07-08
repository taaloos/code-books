<?php
/**
 * Instancia a Classe definida e executa o método processaAcao()
 */
include_once("framework/includes/autoload.inc");
include_once("framework/classes/classe_bancodados.inc");
include_once("framework/classes/classe_html.inc");
include_once("framework/classes/classe_base.inc");
include_once("framework/classes/classe_paginacao.inc");
include_once("framework/classes/classe_formulario.inc");
include_once("framework/includes/configbd.inc");
include_once("framework/includes/autenticacao.inc");

$_path = pathinfo($_SERVER['PHP_SELF']);
if(stripos($_SESSION['AUTORIZADOS'],$_path['basename'])===false&&$_path['basename']!='index.php5') {
	die("<span style='color:red;font-weight:bold;font-size:15px;'>Você não tem Permissão para Acessar Este programa</span>");
}
include_once($_classe["arquivo"]);
if($_path['basename']!='index.php5') {
	setcookie("ULTIMO_PROGRAMA",$_SERVER['PHP_SELF'],time()+365*86400,"/");
}

// Incluir no historico
if($_path['basename']!='index.php5') {
	$_hist = new historico($_bd);
	$_nome_prg = ((strpos($_path['dirname'],"/",1))!==false ? substr($_path['dirname'],strpos($_path['dirname'],"/",1)+1) . "/" : "") . $_path['basename'];
	$_hist->incluirHistorico($_nome_prg);
}
//

$_cl = new $_classe["nome"]($_bd);
return $_cl->processaAcao();
?>