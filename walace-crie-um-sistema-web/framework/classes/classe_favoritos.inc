<?php
/**
 * Classe para gerenciamento de Favoritos
 *
 */
class favoritos extends BASE {
	
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->_nome_tabela = 'favoritos';
		$this->addCampo(new inteiro("USUARIO_ID","Código do Usuário",10,null,null,true,false,true,null,null,null,true));		
		$this->addCampo(new string("PROGRAMA","Nome do Programa",120,null,null,true,false,false,null,null,null,true,$_conn));
	}
	
	/**
	 * Tenta Incluir um Programa na lista de Favoritos
	 *
	 */
	public function addFavorito() {
		$this->getCampo("USUARIO_ID")->setValor($_SESSION['USUARIO_ID']);
		$_path = pathinfo($_POST['programa']);
		$_nome_prg = ((strpos($_path['dirname'],"/",1))!==false 
						? substr($_path['dirname'],strpos($_path['dirname'],"/",1)+1) . "/" 
						: "") . 
					  $_path['basename'];
		$this->getCampo("PROGRAMA")->setValor($_nome_prg);
		if(parent::incluir()!==false) {
			$_sc = new tag(new tipotag("SCRIPT"),null,"alert('programa {$_path['basename']} incluido na lista de favoritos');");
			echo utf8_encode($_sc->toHTML());
		}
		
	}
	
	/**
	 * Retira o programa informado da lista de favoritos
	 *
	 */
	public function delFavorito() {
		$this->getCampo("USUARIO_ID")->setValor($_SESSION['USUARIO_ID']);
		$_path = pathinfo($_POST['programa']);
		$_nome_prg = ((strpos($_path['dirname'],"/",1))!==false 
						? substr($_path['dirname'],strpos($_path['dirname'],"/",1)+1) . "/" 
						: "") . 
					  $_path['basename'];
		$this->getCampo("PROGRAMA")->setValor($_nome_prg);
		file_put_contents("fav.txt",var_export($this,true));
		if(parent::excluir()!==false) {
			$_sc = new tag(new tipotag("SCRIPT"),null,"alert('programa {$_path['basename']} removido da lista de favoritos');");
			echo utf8_encode($_sc->toHTML());
		}
	}
	
	/**
	 * Retorna a lista de favoritos
	 *
	 */
	public function getFavoritos() {
		$_tab = new tag(new tipotag("TABLE"),
						Array(new atributo("STYLE","width:200px;padding:3px;"),
							  new atributo("BORDER",0),new atributo("CELLPADDING",0),new atributo("CELLSPACING",0)));
		// Opções Fixas para adicionar e remover páginas
		$_fixos = Array(Array("addfavorito();","favoritos_add.png","Adicionar programa"),
						Array("delfavorito();","favoritos_del.png","Remover programa"));
		foreach($_fixos as $_item) {
			$_tab->addSubtag(new tag(new tipotag("TR"),
						Array(new atributo("STYLE","height:20px;"),
							  new atributo("ONMOUSEOVER","this.className='DETALHE'"),
							  new atributo("ONMOUSEOUT","this.className=''"))));
			$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
							Array(new atributo("STYLE","cursor:pointer;"),
							  	new atributo("ONCLICK","document.getElementById('FAVORITOS').style.visibility='hidden';" . 
													 "objdivFiltro.reset();objRelatorio.objme.reset();{$_item[0]}"))));
			$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("IMG",false),
								Array(new atributo("BORDER",0),
									  new atributo("WIDTH",20),
									  new atributo("ALIGN","ABSMIDDLE"),
									  new atributo("STYLE","padding:2px;background:transparent;"),
									  new atributo("SRC","framework/imagens/{$_item[1]}"))));
			$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
							Array(new atributo("STYLE","cursor:pointer;font-size:11px;"),
							  	new atributo("ONCLICK","document.getElementById('FAVORITOS').style.visibility='hidden';" . 
													 "objdivFiltro.reset();objRelatorio.objme.reset();{$_item[0]};")),
							$_item[2]));
		}
		if($this->_conn->executaSQL($this->montaSELECT("*","USUARIO_ID={$_SESSION['USUARIO_ID']}"))!==false&&$this->_conn->getNumRows()>0) {
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
			$_lista = Array();
			while($this->proximo()!==false) {
				$_lista[] = "'{$this->getCampo("PROGRAMA")->getValor()}'";
			}
			$_menu = new menu($this->_conn);
			$_listamenu = $_menu->getListaMenus(implode(",",$_lista));
			// montar o menu
			foreach($_lista as $_item) {
				$_item = substr($_item,1,-1);
				$_tab->addSubtag(new tag(new tipotag("TR"),
							Array(new atributo("STYLE","height:20px;"),
								  new atributo("ONMOUSEOVER","this.className='DETALHE'"),
								  new atributo("ONMOUSEOUT","this.className=''"))));
				$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
								Array(new atributo("STYLE","cursor:pointer;"),
								  	new atributo("ONCLICK","document.getElementById('FAVORITOS').style.visibility='hidden';" . 
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
								  	new atributo("ONCLICK","document.getElementById('FAVORITOS').style.visibility='hidden';" . 
														 "objdivFiltro.reset();objRelatorio.objme.reset();" . 
														 "ObjProcAjax.run('{$_item}','CORPO');")),
								$_listamenu[$_item][0]));
		   	}
		}
		echo utf8_encode($_tab->toHTML(false));				
	}
}
?>