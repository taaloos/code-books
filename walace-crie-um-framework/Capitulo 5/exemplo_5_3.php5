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
$_frm = new formulario("FRM_TESTE","javascript:void(0);");
$_frm->addSubtag(new tag(new tipotag("TABLE")));
foreach($_t->filtrarCampos("incluir") as $_campo) {
	$_frm->getLastSubTag()->addSubTag(new tag(new tipotag("TR")));
	$_frm->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),Array(new atributo("STYLE","color:Navy;")),"{$_campo->getTitulo()}:"));
	$_frm->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("TD")));
	$_frm->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag($_campo->toForm());
}
echo $_frm->toHTML(false);
?>