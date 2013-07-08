<?php
/**
 * Exemplo para tratamento de exceções no banco de dados
 * 
 */

include_once("framework/classes/classe_bancodados.inc");

$_bd = new pgsql();
$_bd->SetServidor('localhost');
$_bd->SetBanco('siteweb');
$_bd->SetUsuario('postgres');
$_bd->SetSenha('postgres');
$_bd->SetPorta(5432);
$_bd->Conectar() or die($_bd->getUltimoErro());

$_sql = "SELECT * FROM tab_teste_x";
$_bd->executaSQL($_sql) or die($_bd->getUltimoErro());
echo "Número de registros retornados pelo SELECT: {$_bd->getNumRows()}<br>";
echo "<table border=1 cellpadding=5 width=400><tr><th>Código</th><th>Descrição</th><th>Valor</th></tr>";
while($_d=$_bd->proximo()) {
	echo "<tr><td>{$_d['codigo']}</td><td>{$_d['descricao']}</td><td align='right'>{$_d['valor']}</td></tr>";
}
echo "</table>";
?>