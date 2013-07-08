<?php
/**
 * Contagem de inventário
 * 
 */
$_classe = Array("arquivo"=>"estoque/classes/classe_contagem.inc","nome"=>"contagem");
$_FTitulo = "Contagem de Inventário";
$_GET['ACAO'] = 'INC';
return include_once("../instanciaclasse.php5");
?>