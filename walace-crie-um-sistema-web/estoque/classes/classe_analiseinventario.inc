<?php
/**
 * Classe analise do inventario
 */

class analiseinventario extends base {
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->_nome_tabela = 'inventario';
		$this->_class_path = 'estoque';
		$this->addCampo(new string("INVENTARIO_CODIGO","Inventбrio",10,null,null,true,false,true,1,null,null,false,$_conn));
		$this->getCampo("INVENTARIO_CODIGO")->setComportamento_form('select');
	}
	
	/**
	 * Exibiзгo de uma tela especifica para a anбlise de inventбrio
	 *
	 */
	public function processaAcao() {
		// Sempre mostra o filtro do relatуrio nada mais...
		$_inv = new inventario($this->_conn);
		$this->getCampo("INVENTARIO_CODIGO")->setValor_fixo($_inv->buscaLiberadosFicha());
		$_form = new formulario("ANALISE_{$this->_nome_tabela}","Javascript:void(0);");
		$_form->deleteAtributo(4);
		$_form->addAtributo(new atributo("ONSUBMIT","objAnalise.run(retornaFiltro(this,false));return false;"));
		$_tab = $this->getTabelaFiltro(false);
		$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
										Array(new atributo("COLSPAN",4),
											  new atributo('STYLE','text-align:right;padding-right:20px;'),
											  new atributo("ID","BTNOK"))));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new formInputSubmit("OK"," Analisar o Inventбrio "));
		$_form->addSubTag($_tab);
		$_div = new tag(new tipotag("DIV"),Array(new atributo("ID","RESULTADO_ANALISE")));
		$_sc = new tag(new tipotag("SCRIPT"),null,"LoadJS('estoque/javascript/analise.js');");
		echo utf8_encode($this->getInfoPagina()->toHTML() . $this->inibeBotoes()->toHTML() . 
						 $_form->toHTML() . $_sc->toHTML() . $_div->toHTML());
	}

}
?>