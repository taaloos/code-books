<?php
/**
 * Recupera a senha de um usuário e a envia por email
 * Chamna o método recuperSenha da classe usuario
 */

include_once("framework/classes/classe_bancodados.inc");
include_once("framework/classes/classe_base.inc");
include_once("framework/classes/classe_usuario.inc");
include_once("framework/includes/configbd.inc");
$_usr = new usuario($_bd);
$_usr->recuperaSenha($_GET['usuario']);
?>