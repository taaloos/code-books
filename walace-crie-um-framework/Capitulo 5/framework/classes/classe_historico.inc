<?php
/**
 * Classe para gerenciamento do Histórico de uso
 *
 */
class historico extends BASE {
	
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->_nome_tabela = 'historico';
		$this->addCampo(new inteiro("USUARIO_ID","Código do Usuário",10,null,null,true,false,true,null,null,null,true));		
		$this->addCampo(new string("PROGRAMA","Nome do Programa",120,null,null,true,false,false,null,null,null,true,$_conn));
		$this->addCampo(new inteiro("ACESSOS","Número de Acessos",10,null,null,true,true,false,null,null,null,false));
	}
	
	
	/**
	 * Antes de incluir verificamos se o programa já existe
	 * em caso afirmativo soma-se um ao número de acessos
	 */
	public function incluirHistorico($_programa) {
		$_strSQL = $this->montaSELECT("*","USUARIO_ID={$_SESSION['USUARIO_ID']} AND PROGRAMA='{$_programa}'");
		if($this->_conn->executaSQL($_strSQL)!==false&&$this->_conn->getNumRows()>0) {
			// Alterar..
			$this->proximo();
			$this->getCampo("ACESSOS")->setValor($this->getCampo("ACESSOS")->getValor()+1);
			return parent::alterar();
		} else {
			$this->getCampo("USUARIO_ID")->setValor($_SESSION['USUARIO_ID']);
			$this->getCampo("PROGRAMA")->setValor($_programa);
			$this->getCampo("ACESSOS")->setValor(1);
			return parent::incluir();
		}
	}
	
	public function limparHistorico() {
		$_strSQL = "DELETE FROM {$this->_nome_tabela} WHERE USUARIO_ID={$_SESSION['USUARIO_ID']}";		
		if($this->_conn->executaSQL($_strSQL)!==false) {
			$_sc = new tag(new tipotag("SCRIPT"),null,"alert('Histórico apagado');");
		} else {
			$_sc = new tag(new tipotag("SCRIPT"),null,"alert('Ocorreu um erro na tentativa de apagar o histórico');");
		}
		echo utf8_encode($_sc->toHTML());
	}
	
	public function getHistorico() {
		if($this->_conn->executaSQL($this->montaSELECT("*","USUARIO_ID={$_SESSION['USUARIO_ID']}","ACESSOS DESC",10))!==false&&$this->_conn->getNumRows()>0) {
			$_lista = Array();
			while($this->proximo()!==false) {
				$_lista[] = "'{$this->getCampo("PROGRAMA")->getValor()}'";
			}
			$_menu = new menu($this->_conn);
			$_listamenu = $_menu->getListaMenus(implode(",",$_lista));
			// montar o menu
			$_tab = new tag(new tipotag("TABLE"),
							Array(new atributo("STYLE","width:200px;padding:3px;"),
								  new atributo("BORDER",0),new atributo("CELLPADDING",0),new atributo("CELLSPACING",0)));
			$_tab->addSubtag(new tag(new tipotag("TR"),
						Array(new atributo("ONMOUSEOVER","this.className='DETALHE'"),
							  new atributo("ONMOUSEOUT","this.className=''"))));
			$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD")));
			$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
							Array(new atributo("STYLE","cursor:pointer;font-size:11px;height:20px;"),
							  	new atributo("ONCLICK","document.getElementById('HISTORICO').style.visibility='hidden';" . 
													 "objdivFiltro.reset();objRelatorio.objme.reset();limparhistorico();")),
							"Limpar o Histórico"));
			// Linha Separadora
			$_tab->addSubtag(new tag(new tipotag("TR")));
			$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
							Array(new atributo("COLSPAN",2))));
			$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("IMG",false),
								Array(new atributo("BORDER",0),
									  new atributo("WIDTH","100%"),
									  new atributo("HEIGHT",11),
									  new atributo("ALIGN","ABSMIDDLE"),
									  new atributo("SRC","framework/imagens/linha.png"))));
			foreach($_lista as $_item) {
				$_item = substr($_item,1,-1);
				$_tab->addSubtag(new tag(new tipotag("TR"),
							Array(new atributo("ONMOUSEOVER","this.className='DETALHE'"),
								  new atributo("ONMOUSEOUT","this.className=''"))));
				$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
								Array(new atributo("STYLE","cursor:pointer;"),
								  	new atributo("ONCLICK","document.getElementById('HISTORICO').style.visibility='hidden';" . 
														 "objdivFiltro.reset();objRelatorio.objme.reset();" . 
														 "ObjProcAjax.run('{$_item}','CORPO');"))));
				if($_listamenu[$_item][1]!=""&&$_listamenu[$_item][1]!==null) {
					$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("IMG",false),
									Array(new atributo("BORDER",0),
										  new atributo("WIDTH",20),
										  new atributo("ALIGN","ABSMIDDLE"),
										  new atributo("STYLE","padding:2px;background:transparent;"),
										  new atributo("SRC","framework/imagens/{$_listamenu[$_item][1]}"))));
				}
				$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
								Array(new atributo("STYLE","cursor:pointer;font-size:11px;"),
								  	new atributo("ONCLICK","document.getElementById('HISTORICO').style.visibility='hidden';" . 
														 "objdivFiltro.reset();objRelatorio.objme.reset();" . 
														 "ObjProcAjax.run('{$_item}','CORPO');")),
								$_listamenu[$_item][0]));
		   	}
			echo utf8_encode($_tab->toHTML(false));				
		} else {
			$_tag = new tag(new tipotag("P"),
							Array(new atributo("STYLE","text-align:center;vertical-align:middle;color:red;")),
							"- Nenhum Histórico -");
			echo utf8_encode($_tag->toHTML());
		}
		
	}
	
}
?>