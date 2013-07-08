<?php
/**
 * Exemplo para utilização do controle de transações
 * 2o. executamos algumas mudanças e depois descartamos os comandos
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
$_sql = "insert into tab_teste values(11,'teste 11',21.7)";
$_bd->executaSQL($_sql);
$_sql = "delete from tab_teste"; // Apagamos todos os registros
$_bd->executaSQL($_sql);
$_bd->ROLLBACK();
?>