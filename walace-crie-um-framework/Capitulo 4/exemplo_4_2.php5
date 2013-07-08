<?php
/**
 * Inclusão de vários registros na tabela de testes
 */

include_once("framework/classes/classe_bancodados.inc");

$_bd = new pgsql();
$_bd->SetServidor('localhost');
$_bd->SetBanco('siteweb');
$_bd->SetUsuario('postgres');
$_bd->SetSenha('postgres');
$_bd->SetPorta(5432);
$_bd->Conectar();

$_bd->startTransaction();
for($_i=1000;$_i<=2000;$_i++) {
	$_sql = "insert into tab_teste values({$_i},'Elemento {$_i}'," . (mt_rand(1,10000) / 1000) .")";
	echo $_sql ; 
	var_dump($_bd->executaSQL($_sql));
	echo $_bd->getUltimoErro();
	echo "<br>";
}
$_bd->commit();
?>