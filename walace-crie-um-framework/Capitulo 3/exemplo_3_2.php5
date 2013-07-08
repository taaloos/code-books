<?php
/**
 * Exemplo para utilizaзгo Recuperaзгo de registro no banco de dados
 * Utilizando as classes do pacote html
 */

include_once("framework/classes/classe_bancodados.inc");
include_once("framework/classes/classe_html.inc");
$_bd = new pgsql();
$_bd->SetServidor('localhost');
$_bd->SetBanco('siteweb');
$_bd->SetUsuario('postgres');
$_bd->SetSenha('postgres');
$_bd->SetPorta(5432);
$_bd->Conectar();

$_sql = "SELECT * FROM tab_teste";
$_bd->executaSQL($_sql);

$_html = new html(); 
$_tipos = new tipospadrao();
$_tag1 = new tag($_tipos->getTipo('HTML'));
$_body = new tag($_tipos->getTipo('BODY'));
$_body->addSubTag(new tag($_tipos->getTipo('P'),null,"Nъmero de registros retornados pelo SELECT: {$_bd->getNumRows()}"));
$_tab = new tag($_tipos->getTipo('TABLE'),Array(new atributo("BORDER",1),new atributo("CELLPADDING",5),new atributo("WIDTH",400)));
$_tr  = new tag($_tipos->getTipo('TR'));
$_tr->addSubTag(new tag($_tipos->getTipo('TH'),null,'Cуdigo'));
$_tr->addSubTag(new tag($_tipos->getTipo('TH'),null,'Descriзгo'));
$_tr->addSubTag(new tag($_tipos->getTipo('TH'),null,'Valor'));
$_tab->addSubTag($_tr);
$_tag1->addSubTag($_body);
$_html->addTag($_tag1);
$_c=0;
while($_d=$_bd->proximo()) {
	$_det[$_c] = new tag($_tipos->getTipo('TR'));
	$_det[$_c]->addSubTag(new tag($_tipos->getTipo('TD'),null,$_d['CODIGO']));
	$_det[$_c]->addSubTag(new tag($_tipos->getTipo('TD'),null,$_d['DESCRICAO']));
	$_det[$_c]->addSubTag(new tag($_tipos->getTipo('TD'),Array(new atributo('ALIGN','right')),$_d['VALOR']));
	$_tab->addSubTag($_det[$_c]);
	++$_c;
}
$_body->addSubTag($_tab);
$_html->setOtimizado(false);
echo $_html->toHTML();
?>