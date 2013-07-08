<?php
/**
 * Exemplo para utilizaчуo da classe bancodados e suas descendentes
 */

include_once("framework/classes/classe_bancodados.inc");

$_bd = new pgsql();
$_bd->SetServidor('localhost');
$_bd->SetBanco('siteweb');
$_bd->SetUsuario('postgres');
$_bd->SetSenha('postgres');
$_bd->SetPorta(5432);
var_dump($_bd->Conectar());
?>