<?php
/**
 * Exemplo para geração de formulário html
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
		$this->addCampo(new inteiro("CODIGO","Código",10,null,null,true,false,true,null,null,null,true));
		$this->addCampo(new string("DESCRICAO","Descrição",50,null,null,true,true,true,null,null,null,false,$_conn));
		$this->addCampo(new dinheiro("VALOR","Valor",12,null,null,true,true,true,null,null,null,false));
		$this->addCampo(new string("ATIVO","Registro Ativo",1,null,null,true,true,true,null,null,null,false));
		$this->getCampo("ATIVO")->setComportamento_form("checkbox");
		$this->getCampo("ATIVO")->setMarcar(true);
		$this->getCampo("ATIVO")->setValor_Fixo("S");
		$this->addCampo(new data("DATA","Data de Entrada",12,null,null,true,true,true,null,null,null,false));
	}
	
}
$_t = new teste($_bd);
$_html = new tag(new tipotag("HTML"));
$_html->addSubTag(new tag(new tipotag("HEAD")));
$_html->getLastSubTag()->addSubTag(new tag(new tipotag("LINK",false),
									Array(new atributo("REL","STYLESHEET"),
										  new atributo("TYPE","text/css"),
										  new atributo("HREF","framework/css/epoch_styles.css"))));
$_html->getLastSubTag()->addSubTag(new tag(new tipotag("SCRIPT"),Array(new atributo("SRC","framework/javascript/epoch.js"))));
$_html->getLastSubTag()->addSubTag(new tag(new tipotag("SCRIPT"),Array(new atributo("SRC","framework/javascript/funcoesgenericas.js"))));
$_html->getLastSubTag()->addSubTag(new tag(new tipotag("SCRIPT"),Array(new atributo("SRC","framework/javascript/scriptaculous/prototype.js"))));
$_html->addSubTag(new tag(new tipotag("BODY"),null,utf8_decode($_t->getFormulario())));
echo $_html->toHTML(false);
?>
