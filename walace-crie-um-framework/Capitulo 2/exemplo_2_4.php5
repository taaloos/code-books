<?php
/**
 * Exemplo para utilização do controle de transações
 * 1o. executamos mudanças permanentes
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
$_sql = "insert into tab_teste values(10,'teste 10',15.1)";
$_bd->executaSQL($_sql);
$_sql = "delete from tab_teste where codigo=1";
$_bd->executaSQL($_sql);
$_bd->commit();
?>