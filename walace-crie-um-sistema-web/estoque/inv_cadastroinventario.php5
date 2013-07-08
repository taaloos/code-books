<?php
/**
 * Cadastro de Inventário
 * 
 */
if($_GET['ITENS']=='S'||$_POST['ITENS']=='S') {
	$_classe = Array("arquivo"=>"estoque/classes/classe_inventarioproduto.inc","nome"=>"inventarioproduto");
	$_FTitulo = "Cadastro de Inventário - Itens";
} else {
	$_classe = Array("arquivo"=>"estoque/classes/classe_inventario.inc","nome"=>"inventario");
	$_FTitulo = "Cadastro de Inventários";
}
return include_once("../instanciaclasse.php5");
?>