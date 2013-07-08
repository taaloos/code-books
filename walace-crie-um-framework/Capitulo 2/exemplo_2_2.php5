<?php
/**
 * Exemplo para utilização do método executaSQL()
 */

include_once("framework/classes/classe_bancodados.inc");

$_bd = new pgsql();
$_bd->SetServidor('localhost');
$_bd->SetBanco('siteweb');
$_bd->SetUsuario('postgres');
$_bd->SetSenha('postgres');
$_bd->SetPorta(5432);
$_bd->Conectar();
$_sql = "create table tab_teste(codigo int4 default 0, descricao varchar(20), valor float, primary key(codigo))";
if($_bd->executaSQL($_sql)!==false) {
	echo "TABELA tab_teste CRIADA!!!<br>";
}
$_sql = "insert into tab_teste values(1,'teste',1.5)";
if($_bd->executaSQL($_sql)!==false) {
	echo "1o Registro inserido<br>";
}
$_sql = "insert into tab_teste values(2,'teste 2',3.5)";
if($_bd->executaSQL($_sql)!==false) {
	echo "2o Registro inserido<br>";
}
$_sql = "insert into tab_teste values(5,'teste 3',7.12)";
if($_bd->executaSQL($_sql)!==false) {
	echo "3o Registro inserido<br>";
}
?>