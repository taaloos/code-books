<?php
/**
 * Exemplo do método alterar() da classe base
 */

include_once("framework/classes/classe_bancodados.inc");
include_once("framework/classes/classe_base.inc");

$_bd = new pgsql();
$_bd->SetServidor('localhost');
$_bd->SetBanco('siteweb');
$_bd->SetUsuario('postgres');
$_bd->SetSenha('postgres');
$_bd->SetPorta(5432);
$_bd->Conectar();

class teste extends BASE {
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->_nome_tabela = 'tab_teste';
		$this->addCampo(new inteiro("CODIGO","Código",10,null,null,true,false,true,null,null,null,true));
		$this->addCampo(new string("DESCRICAO","Descrição",50,null,null,true,true,true,null,null,null,false,$_conn));
		$this->addCampo(new dinheiro("VALOR","Valor",12,null,null,true,true,true,null,null,null,false));
	}
}
$_t = new teste($_bd);
$_t->getCampo('CODIGO')->setValor(3010);
$_t->getCampo('VALOR')->setValor('9012,17');
if(($_r=$_t->alterar())===false) {
	echo "Erro na Alteração....{$_t->getConn()->getUltimoErro()}<br>";
} else {
	echo "Registros alterados {$_r}<br>";
}
$_r = $_t->Buscar(Array('CODIGO'=>3010));
if($_r===false||$_r<=0) {
	echo "Nenhum Registro encontrado...";
} else {
	$_t->proximo();
	echo "Código: {$_t->getCampo('CODIGO')->toHTML()} <br>Descrição: {$_t->getCampo('DESCRICAO')->toHTML()} <br>" . 
		 "Valor: {$_t->getCampo('VALOR')->toHTML()}";
}
?>