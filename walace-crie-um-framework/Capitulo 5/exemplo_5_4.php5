<?php
/**
 * Exemplo para geraзгo de formulбrio html
 */


include_once("framework/classes/classe_bancodados.inc");
include_once("framework/classes/classe_html.inc");
include_once("framework/classes/classe_base.inc");
include_once("framework/classes/classe_paginacao.inc");
include_once("framework/classes/classe_formulario.inc");

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
		$this->addCampo(new inteiro("CODIGO","Cуdigo",10,null,null,true,false,true,null,null,null,true));
		$this->addCampo(new string("DESCRICAO","Descriзгo",50,null,null,true,true,true,null,null,null,false,$_conn));
		$this->addCampo(new dinheiro("VALOR","Valor",12,null,null,true,true,true,null,null,null,false));
		$this->addCampo(new string("ATIVO","Registro Ativo",1,null,null,true,true,true,null,null,null,false));
		$this->getCampo("ATIVO")->setComportamento_form("checkbox");
		$this->getCampo("ATIVO")->setMarcar(true);
		$this->getCampo("ATIVO")->setValor_Fixo("S");
	}
}
$_t = new teste($_bd);
echo utf8_decode($_t->getFormulario());
?>