<?php
/**
 * Classe inventario
 */

class congelamento extends base {
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->_nome_tabela = 'inventario';
		$this->_class_path = 'estoque';
		$this->addCampo(new string("INVENTARIO_CODIGO","Inventário",10,null,null,true,false,true,1,null,null,false,$_conn));
		$this->getCampo("INVENTARIO_CODIGO")->setComportamento_form('select');
	}
	
	/**
	 * Sempre executamos o módulo de relatório especial
	 *
	 */
	public function processaAcao() {
		// Sempre mostra o filtro do relatório nada mais...
		$_inv = new inventario($this->_conn);
		$this->getCampo("INVENTARIO_CODIGO")->setValor_fixo($_inv->buscaLiberados());
		$_form = new formulario("CONGELAR_{$this->_nome_tabela}","Javascript:void(0);");
		$_form->deleteAtributo(4);
		$_form->addAtributo(new atributo("ONSUBMIT","objCongelamento.run(retornaFiltro(this,false));return false;"));
		$_tab = $this->getTabelaFiltro(false);
		$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
										Array(new atributo("COLSPAN",4),
											  new atributo('STYLE','text-align:right;padding-right:20px;'),
											  new atributo("ID","BTNOK"))));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new formInputSubmit("OK"," Congelar Inventário "));
		$_form->addSubTag($_tab);
		$_sc = new tag(new tipotag("SCRIPT"),null,"LoadJS('estoque/javascript/congelamento.js');");
		echo utf8_encode($this->getInfoPagina()->toHTML() . $this->inibeBotoes()->toHTML() . $_form->toHTML() . $_sc->toHTML());
	}
	
	public function congelar() {
		$_cinv = $_POST['inventario'];
		$_inv = new inventario($this->_conn);
		if($_inv->Buscar(Array('INVENTARIO_CODIGO'=>$_cinv))===false) {
			echo utf8_encode("<span style='color:red;'>Inventário {$_cinv} Não Encontrado</span>");
		} else {
			$_inv->proximo();
			if($_inv->getCampo("INVENTARIO_CONGELADO")=='S') {
				echo utf8_encode("<span style='color:red;'>Inventário {$_cinv} Já está congelado</span>");
			} else {
				$this->_conn->startTransaction();
				$_itens = new inventarioproduto($this->_conn);
				if($_itens->congelar($_cinv)===false) {
					$this->_conn->ROLLBACK();
					echo utf8_encode("<span style='color:red;'>Não foi possível executar o congelamento dos itens do Inventário {$_cinv}</span>");
				} else {
					if($_inv->congelar($_cinv)===false) {
						$this->_conn->ROLLBACK();
						echo utf8_encode("<span style='color:red;'>Não foi possível executar o congelamento do Inventário {$_cinv}</span>");
					} else {
						$this->_conn->commit();
						echo utf8_encode("<span style='color:Navy;'>Inventário {$_cinv} congelado com sucesso.</span>");
					}
				}
			}
		}
	}
}
?>