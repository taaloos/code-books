<?php
/**
 * Classe contagem do inventario
 */
class contagem extends base {
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->_nome_tabela = 'contagem';
		$this->_class_path = 'estoque';
		$this->addCampo(new string("INVENTARIO_CODIGO","Inventбrio",10,null,null,true,false,true,1,null,null,true,$_conn));
		$this->addCampo(new inteiro("CONTAGEM_NUMERO","Nъmero da contagem",5,null,null,true,false,true,1,null,null,true));
		$this->addCampo(new string("PRODUTO_CODIGO","Produto",20,null,null,true,false,true,1,null,null,true,$_conn));
		$this->addCampo(new string("LOCAL_CODIGO","Local",10,null,null,true,false,true,1,null,null,true,$_conn));
		$this->addCampo(new float("CONTAGEM_ESTOQUE","Quantidade Contada",12,null,null,true,false,true,0,null,null,false));
		$this->addCampo(new string("USUARIO_LOGIN","Usuбrio",20,null,null,false,false,false,null,null,null,false,$_conn));
		$this->addCampo(new datahora("DATA_ULTIMA_ALTERACAO","Data",14,null,null,false,false,false,null,null,null,false,$_conn));
		$this->getCampo("INVENTARIO_CODIGO")->setComportamento_form('select');
		$this->getCampo("PRODUTO_CODIGO")->setComportamento_form('select');
		$this->getCampo("LOCAL_CODIGO")->setComportamento_form('select');
	}
	
	
	/**
	 * Ajusta o comportamento dos campos do formulбrio
	 *
	 */
	protected function processaCampoFormulario($_nome,tag &$_campo,$_metodo) {
		if(stripos($_metodo,'getformulario')!==false) {
			switch($_nome) {
				case 'CONTAGEM_ESTOQUE':
				case 'CONTAGEM_NUMERO':		$_campo->addAtributo(new atributo("DISABLED"));
											break;
				case 'INVENTARIO_CODIGO':	$_campo->addAtributo(new atributo("ONCHANGE","objContagem.habilita();" . 
																						 "objContagem.buscaContagem();" . 
																						 "objContagem.buscaProdutos();"));
											break;
				case 'PRODUTO_CODIGO':		$_campo->addAtributo(new atributo("ONCHANGE","objContagem.buscaLocais();"));
											break;
				case 'LOCAL_CODIGO':		$_campo->addAtributo(new atributo("ONCHANGE","objContagem.habilita();"));
											break;
			}
		}
	}
	
	
	/**
	 * Nгo й possнvel excluir uma contagem
	 *
	 */
	public function Excluir() {
		return false;
	}
	
	/**
	 * Nгo й possнvel alterar uma contagem
	 *
	 * @return unknown
	 */
	public function Alterar() {
		return false;
	}
	
	/**
	 * Monta o formulбrio especifico de entrada de contagem
	 *
	 * @param string $_funcao
	 * @return string
	 */
	public function getFormulario($_funcao='INC') {
		$_inv = new inventario($this->_conn);
		$_opc = Array(Array('label'=>'Selecione um Inventбrio','valor'=>'-'));
		$this->getCampo("INVENTARIO_CODIGO")->setValor_Fixo(Array_merge($_opc,$_inv->buscaLiberadosFicha()));
		$_form = new formulario("FRM_{$this->_nome_tabela}","#");
		$_form->deleteAtributo(4);
		$_form->addAtributo(new atributo("ONSUBMIT","objContagem.gravar();return false;"));
		$_form->addSubTag(new tag(new tipotag("SCRIPT"),null,"objForm.construct();"));
		$_tab  = new tag(new tipotag("TABLE"),
						 Array(new atributo("BORDER",0),new atributo("CELLPADDING",2),new atributo("CELLSPACING",0)));
		$_tr = new tipotag("TR");
		$_td = new tipotag("TD");
		$_num_colunas = 1;
		$_cols = $_num_colunas+1;
		$_foco = null;
		$_lhidden = Array();
		foreach($this->filtrarCampos() as $_campo) {
			if($_cols>$_num_colunas) {
				$_tab->addSubTag(new tag($_tr));
				$_cols = 1;
			}
			++$_cols;
			$_tab->getLastSubTag()->addSubTag(new tag($_td,Array(new atributo("STYLE","color:Navy;width:200px;padding-left:5px;")),"{$_campo->getTitulo()}:"));
			$_tab->getLastSubTag()->addSubTag(new tag($_td));
			if($_foco===null) {
				$_foco = $_campo->getNome();
			}
			if(strtolower($_campo->getComportamento_form())=='radio'&&is_array($_campo->getValor_fixo())) {
				foreach($_campo->getValor_Fixo() as $_opcao) {
					$_cpoform = new formInputRadio($_campo->getNome(),$_opcao['valor'],$_opcao['label'],null,null,
												   ($_opcao['marcar']===true||$_campo->getValor()==$_opcao['valor']));
					$this->processaCampoFormulario($_campo->getNome(),$_cpoform,__METHOD__);
					$_tab->getLastSubTag()->getLastSubTag()->addSubTag($_cpoform);
					$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag('BR',false)));
				}
			} else {
				$_cpoform = $_campo->toForm();
				$this->processaCampoFormulario($_campo->getNome(),$_cpoform,__METHOD__);
				$_tab->getLastSubTag()->getLastSubTag()->addSubTag($_cpoform);
				
			}
		}
		$_tab->addSubTag(new tag($_tr));
		$_tab->getLastSubTag()->addSubTag(new tag($_td,Array(new atributo("COLSPAN",$_num_colunas*2),new atributo('ALIGN','CENTER'),new atributo("ID","BTNOK"))));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new formInputSubmit("OK"," Gravar Contagem"));
		$_form->addSubTag($_tab);
		if($_foco!==null) {
			$_form->addSubTag(new tag(new tipotag("SCRIPT"),null,"document.getElementById('{$_foco}').focus();"));
		}
		$_tab = new tag(new tipotag('TABLE'),Array(new atributo("BORDER",0),
														new atributo("CELLPADDING",1),
														new atributo("STYLE","border:1px solid #a0a0a0;border-collapse:collapse;"),
														new atributo("WIDTH","100%"),
														new atributo("ID","TAB_CONTAGEM")));
		$_bd  = new tag(new tipotag("TBODY"));
		$_tr  = new tag($_tr);
		$_tr->addSubTag(new tag(new tipotag('TH'),Array(new atributo("STYLE","border:1px solid #a0a0a0;background-color:#f0f0f0;")),"Inventбrio"));
		$_tr->addSubTag(new tag(new tipotag('TH'),Array(new atributo("STYLE","border:1px solid #a0a0a0;background-color:#f0f0f0;")),"Contagem"));
		$_tr->addSubTag(new tag(new tipotag('TH'),Array(new atributo("STYLE","border:1px solid #a0a0a0;background-color:#f0f0f0;")),"Produto"));
		$_tr->addSubTag(new tag(new tipotag('TH'),Array(new atributo("STYLE","border:1px solid #a0a0a0;background-color:#f0f0f0;")),"Local"));
		$_tr->addSubTag(new tag(new tipotag('TH'),Array(new atributo("STYLE","border:1px solid #a0a0a0;background-color:#f0f0f0;")),"Quantidade"));
		$_tr->addSubTag(new tag(new tipotag('TH'),Array(new atributo("STYLE","border:1px solid #a0a0a0;background-color:#f0f0f0;")),"Situaзгo"));
		$_bd->addSubTag($_tr);
		$_tab->addSubTag($_bd);
		return utf8_encode($_form->toHTML() . $_tab->toHTML());
	}

	/**
	 * Processa a Acao, que no caso й sempre Inc
	 *
	 * @param string $_acao
	 */
	public function processaAcao($_acao='INC') {
		$_sc = new tag(new tipotag("SCRIPT"),null,"LoadJS('estoque/javascript/contagem.js');");
		echo utf8_encode($this->getInfoPagina()->toHTML() . $this->inibeBotoes()->toHTML());
		parent::processaAcao();
		echo $_sc->toHTML();
	}
	
	/**
	 * Grava a contagem
	 * 
	 */
	public function GravarContagem() {
		// inventбrio, contagem, produto, local, quantidade...
		foreach($this->filtrarCampos("incluir") as $_nome=>$_campo) {
			$_campo->setValor($_POST[$_nome]);
		}
		$this->SetUsuarioeData();
		if(($_res=$this->incluir())!==false) {
			echo "Contagem Gravada";
		} else {
			echo utf8_encode("Erro na gravaзгo:{$_res} {$this->_conn->getUltimoErro()}");
		}
	}
}
?>