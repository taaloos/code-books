<?php
/**
 * Classe Formulário Relatório
 * Retorna para o browser um formulário para
 * parametrização do relatório solicitado
 */
class formularioRelatorio extends tag {
	/**
	 * Instancia da Classe Base
	 *
	 * @var BASE
	 */
	protected $_classe = null;
	
	public function __construct(BASE $_classe) {
		$this->_classe = $_classe;
		parent::__construct(new tipotag("FORM"),
							Array(new atributo("NAME",get_class($this->_classe)),
								  new atributo("ID",get_class($this->_classe)),
								  new atributo("ACTION","javascript:void(0);"),
								  new atributo("ONSUBMIT","objRelatorio.run();return false;")));
	}
	
	public function getListaCampos() {
		$_lista = Array();
		foreach($this->_classe->filtrarCampos("relatorio") as $_campo) {
			$_lista[] = Array("valor"=>$_campo->getNome(),"label"=>$_campo->getTitulo());
		}
		return $_lista;
	}
	
	public function getFormularioRelatorio() {
		$_tab  = new tag(new tipotag("TABLE"),
						 Array(new atributo("BORDER",0),new atributo("CELLPADDING",5),
						 	   new atributo("CELLSPACING",0),new atributo("WIDTH","100%")));
		$_tr = new tipotag("TR");
		$_td = new tipotag("TD");
		$_tab->addSubTag(new tag($_tr));
		$_tab->getLastSubTag()->addSubTag(new tag($_td,
							Array(new atributo("COLSPAN",5),
								  new atributo("STYLE","text-align:left;font-weight:bold;color:#ffffff;background-color:#aaccff;border-bottom:1px solid #c0c0c0;padding-left:10px;")),"R E L A T Ó R I O"));
		$_tab->addSubTag(new tag($_tr));
		$_tab->getLastSubTag()->addSubTag(new tag($_td,
							Array(new atributo("COLSPAN",5),
								  new atributo("STYLE","height:10px;font-size:1px;")),"&nbsp;"));
		$_tab->addSubTag(new tag($_tr));
		// Disponiveis
		$_tab->getLastSubTag()->addSubTag(new tag($_td,Array(new atributo("VALIGN","TOP"),new atributo("WIDTH",180)))); 
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("SPAN"),Array(new atributo("STYLE","background-color:#4682B4;color:white;font-size:11px;padding:3px;")),"&nbsp;Disponiveis&nbsp;&nbsp;"));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("BR",false)));
		$_msel = new formSelect("CAMPOS_CLASSE",true,$this->getListaCampos(),null,null);
		$_msel->addAtributo(new atributo("SIZE",15));
		$_msel->addAtributo(new atributo("STYLE","width:200px;"));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag($_msel);
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("BR",false)));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("DIV"),Array(new atributo("STYLE","text-align:left;position:relative;top:5px;left:170px;"))));
		$_tab->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("IMG"),
												Array(new atributo("SRC","framework/imagens/check.png"),
													  new atributo("BORDER",0),
													  new atributo("STYLE","cursor:pointer;"),
													  new atributo("TITLE","Marcar Todos"),
													  new atributo("ONCLICK","objRelatorio.checkall('CAMPOS_CLASSE');"))));
		// Opcoes
		$_tab->getLastSubTag()->addSubTag(new tag($_td,Array(new atributo("VALIGN","MIDDLE"),
															 new atributo("ALIGN","CENTER"),
															 new atributo("WIDTH",70)))); 
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("IMG"),
												Array(new atributo("SRC","framework/imagens/add-item.png"),
													  new atributo("BORDER",0),
													  new atributo("STYLE","cursor:pointer;"),
													  new atributo("ONCLICK","objRelatorio.move('CAMPOS_CLASSE','CAMPOS_SELECIONADOS');"))));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("BR",false)));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("IMG"),
												Array(new atributo("SRC","framework/imagens/remove-item.png"),
													  new atributo("STYLE","cursor:pointer;"),
													  new atributo("BORDER",0),
													  new atributo("ONCLICK","objRelatorio.move('CAMPOS_SELECIONADOS','CAMPOS_CLASSE');"))));
		// Selecionados
		$_tab->getLastSubTag()->addSubTag(new tag($_td,Array(new atributo("VALIGN","TOP"),new atributo("WIDTH",180)))); 
		$_msel = new formSelect("CAMPOS_SELECIONADOS",true);
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("SPAN"),Array(new atributo("STYLE","background-color:#4682B4;color:white;font-size:11px;padding:3px;")),"&nbsp;Selecionados&nbsp;&nbsp;"));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("BR",false)));
		$_msel->addAtributo(new atributo("SIZE",15));
		$_msel->addAtributo(new atributo("STYLE","width:200px;"));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag($_msel);
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("BR",false)));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("DIV"),Array(new atributo("STYLE","text-align:left;position:relative;top:5px;left:170px;"))));
		$_tab->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("IMG"),
												Array(new atributo("SRC","framework/imagens/check.png"),
													  new atributo("BORDER",0),
													  new atributo("STYLE","cursor:pointer;"),
													  new atributo("TITLE","Marcar Todos"),
													  new atributo("ONCLICK","objRelatorio.checkall('CAMPOS_SELECIONADOS');"))));
		// Opcoes
		$_tab->getLastSubTag()->addSubTag(new tag($_td,Array(new atributo("VALIGN","MIDDLE"),
															 new atributo("ALIGN","CENTER"),
															 new atributo("WIDTH",70)))); 
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("IMG"),
												Array(new atributo("SRC","framework/imagens/add-item.png"),
													  new atributo("STYLE","cursor:pointer;"),
													  new atributo("BORDER",0),
													  new atributo("ONCLICK","objRelatorio.copy('CAMPOS_SELECIONADOS','CAMPOS_ORDEM');"))));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("BR",false)));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("IMG"),
												Array(new atributo("SRC","framework/imagens/remove-item.png"),
													  new atributo("STYLE","cursor:pointer;"),
													  new atributo("BORDER",0),
													  new atributo("ONCLICK","objRelatorio.remove('CAMPOS_ORDEM');"))));
		// Ordem
		$_tab->getLastSubTag()->addSubTag(new tag($_td,Array(new atributo("STYLE","vertical-align:TOP;width:180px;text-align:left")))); 
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("SPAN"),Array(new atributo("STYLE","background-color:#4682B4;color:white;font-size:11px;padding:3px;")),"&nbsp;Ordenar por&nbsp;&nbsp;"));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("BR",false)));
		$_msel = new formSelect("CAMPOS_ORDEM",true);
		$_msel->addAtributo(new atributo("SIZE",15));
		$_msel->addAtributo(new atributo("STYLE","width:200px;"));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag($_msel);
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("BR",false)));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("DIV"),Array(new atributo("STYLE","text-align:left;position:relative;top:5px;left:170px;"))));
		$_tab->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("IMG"),
												Array(new atributo("SRC","framework/imagens/check.png"),
													  new atributo("BORDER",0),
													  new atributo("STYLE","cursor:pointer;"),
													  new atributo("TITLE","Marcar Todos"),
													  new atributo("ONCLICK","objRelatorio.checkall('CAMPOS_ORDEM');"))));
		// FIM
		$_tab->addSubTag(new tag($_tr));
		$_tab->getLastSubTag()->addSubTag(new tag($_td,Array(new atributo("COLSPAN",3),new atributo('STYLE','text-align:left;padding-left:5px;'))));
		
		if(($_filtro=$this->_classe->getFiltro())!==null) {
			$_filtro_html = utf8_decode(implode(", ",$_filtro["HTML"]));
		}
		
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new formInputCheckBox("USARFILTRO","S",null,null,null,true));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("SPAN"),Array(new atributo("STYLE","font-size:11px;"))," Aplicar Filtro ao Relatório"));
		$_tab->getLastSubTag()->addSubTag(new tag($_td,Array(new atributo("COLSPAN",2),new atributo('STYLE','text-align:right;padding-right:20px;'),new atributo("ID","BTNOK"))));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new formInputSubmit("OK"," Gerar Relatório "));
		$this->addSubTag($_tab);
		echo utf8_encode($this->toHTML(false));
	}
}

/**
 * Classe para geração do relatório conforme os parametros enviados
 *
 */
class relatorio extends tag {
	/**
	 * @var BASE
	 */
	protected $_classe = null;
	protected $_tipos  = null;
	
	public function __construct(BASE $_classe) {
		$this->_classe = $_classe;
		parent::__construct(new tipotag("HTML"));
		$this->_tipos = new tipospadrao();
	}
	
	protected function addCabecalho() {
		$this->addSubTag(new tag($this->_tipos->getTipo("HEAD")));
		$this->getLastSubTag()->addSubTag(new tag($this->_tipos->getTipo("TITLE"),null,"Sistema WEB"));
		$this->addSubTag(new tag($this->_tipos->getTipo("BODY"),Array(new atributo("WIDTH","95%"))));
		// Cabeçalho
		$this->getLastSubTag()->addSubTag(new tag($this->_tipos->getTipo("DIV"),Array(new atributo("ID","HEADER"),new atributo("STYLE","color:#a0a0a0;padding:5px;"))));
		$this->getLastSubTag()->getLastSubTag()->addSubTag(new tag($this->_tipos->getTipo("TABLE"),Array(new atributo("BODER",0))));
		$this->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag($this->_tipos->getTipo("TR")));
		$this->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag($this->_tipos->getTipo("TD"),Array(new atributo("WIDTH","470px"))));
		// Logo do sistema
		$this->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(
				new tag($this->_tipos->getTipo("IMG"),Array(new atributo("SRC","framework/imagens/logo.png"),new atributo("BORDER",0),new atributo("ALIGN","BOTTOM"))));
		$this->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(
								new tag($this->_tipos->getTipo("TD"),Array(new atributo("WIDTH","470px"),
																	 new atributo("ALIGN","RIGHT"),
																	 new atributo("STYLE","vertical-align:bottom;padding-right:5px;"))));
		$this->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(
								new tag($this->_tipos->getTipo("SPAN"),Array(new atributo("STYLE","font-size:14px;font-weight:bold;color:Navy;")),utf8_decode($_POST['titulo'])));
		$this->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag($this->_tipos->getTipo("BR",false)));
		$this->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag($this->_tipos->getTipo("BR",false)));
		$this->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(
								new tag($this->_tipos->getTipo("SPAN"),Array(new atributo("STYLE","font-size:11px;color:#a0a0a0;")),date("d-m-Y H:i:s")));
	}
	
	public function Imprimir() {
		$this->addCabecalho();
		$_camposlista = $_POST['campos'];
		$_camposrel   = $this->_classe->filtrarCampos("relatorio");
		foreach($_camposrel as $_chv=>$_campo) {
			if(stripos(",{$_camposlista},",",{$_chv},")===false) {
				unset($_camposrel[$_chv]);
			}
		}
		$_filtro_html = null;
		if(($_filtro=$this->_classe->getFiltro())!==null&&$_POST['filtro']=='S') {
			$_filtro_html = utf8_decode(implode(", ",$_filtro["HTML"]));
			$_filtro = implode(" AND ",$_filtro["SQL"]);
		} else {
			$_filtro = null;
		}
		$_ordem = ($_POST['ordem']!="" ? $_POST['ordem'] . "," : "") . implode(",",array_keys($this->_classe->filtrarCampos("pk")));
		$_strSQL = $this->_classe->montaSELECT($_camposlista,$_filtro,$_ordem,null,null,"relatorio");
		$_tab = new tag($this->_tipos->getTipo('TABLE'),Array(new atributo("BORDER",0),
														new atributo("CELLPADDING",5),
														new atributo("CELLSPACING",3),
														new atributo("STYLE","border-collapse:collapse;"),
														new atributo("WIDTH","940")));
		$_tr  = new tag($this->_tipos->getTipo('TR'));
		foreach($_camposrel as $_campo) {
			$_tr->addSubTag(new tag($this->_tipos->getTipo('TH'),Array(new atributo("STYLE","border-bottom:2px solid #a0a0a0;")),
									$_campo->getTitulo()));
		}
		$_tab->addSubTag($_tr);
		if($this->_classe->getConn()->executaSQL($_strSQL)!==false&&$this->_classe->getConn()->getNumRows()>0) {
			while($this->_classe->proximo()) {
				$_tab->addSubtag(new tag($this->_tipos->getTipo('TR')));
				$_pk = "";
				$this->_classe->processaRelatorio();
				foreach($_camposrel as $_campo) {
					$_tab->getLastSubTag()->addSubTag(new tag($this->_tipos->getTipo('TD'),
												  Array($_campo->getAtributosExtras()),
												  $_campo->toHTML()));
				}
			}
			$_trf = new tag($this->_tipos->getTipo('TR'));
			$_trf->addSubTag(new tag($this->_tipos->getTipo("TD"),Array(new atributo("COLSPAN",sizeof($_camposrel)),
																  new atributo("STYLE","color:#a0a0a0;font-size:11px;border-top:1px solid #a0a0a0;")),
									 "Total de {$this->_classe->getConn()->getNumRows()} Registro(s)"));
			$_tab->addSubTag($_trf);
		} else {
			$_trf = new tag($this->_tipos->getTipo('TR'));
			$_trf->addSubTag(new tag($this->_tipos->getTipo("TD"),Array(new atributo("COLSPAN",sizeof($_camposrel)),
																  new atributo("STYLE","text-align:center"))," Nenhum Registro "));
			$_tab->addSubTag($_trf);
			
		}
		$this->getLastSubTag()->addSubTag($_tab);
		if($_filtro_html!==null) {
			$this->getLastSubTag()->addSubTag(new tag($this->_tipos->getTipo("DIV"),Array(new atributo("STYLE","padding:10px;color:#c0c0c0;font-size:12px;")),"Filtro Aplicado: {$_filtro_html}"));
		}
		$this->addbotaoimpressao();
		return utf8_encode($this->toHTML(false));
	}
	
	/**
	 * Adiciona o botão de impressão do relaório
	 *
	 */
	protected function addbotaoimpressao() {
		$this->getLastSubTag()->addSubTag(new tag($this->_tipos->getTipo("DIV"),
						Array(new atributo("ID","DIVPRINT"),
							  new atributo("STYLE","padding:10px;text-align:right;"))));
		$this->getLastSubTag()->getLastSubTag()->addSubTag(new tag($this->_tipos->getTipo("IMG"),
						Array(new atributo("SRC","framework/imagens/print.png"),
							  new atributo("BORDER",0),
							  new atributo("ID","BTN_PRINT"),
							  new atributo("TITLE","Imprimir"),
							  new atributo("STYLE","cursor:pointer"),
							  new atributo("ONCLICK","this.parentNode.style.display='none';window.print();" . 
							  						 "var obj=this;setTimeout(function(){obj.parentNode.style.display='block';},3000);")
		)));
	}
	
	/**
	 * Método para impressões especais
	 * utilizado para gerar relatórios no sistema
	 *
	 * @return string
	 */
	public function imprimirEspecial() {
		$this->addCabecalho();
		$_camposrel   = $this->_classe->filtrarCampos("relatorio");
		$_strSQL = $this->_classe->montaSELECT($_camposrel);
		$_tab = new tag($this->_tipos->getTipo('TABLE'),Array(new atributo("BORDER",0),
														new atributo("CELLPADDING",5),
														new atributo("CELLSPACING",3),
														new atributo("STYLE","border-collapse:collapse;"),
														new atributo("WIDTH","100%")));
		$_tr  = new tag($this->_tipos->getTipo('TR'));
		foreach($_camposrel as $_campo) {
			$_tr->addSubTag(new tag($this->_tipos->getTipo('TH'),Array(new atributo("STYLE","border-bottom:2px solid #a0a0a0;")),
									$_campo->getTitulo()));
		}
		$_tab->addSubTag($_tr);
		if($this->_classe->getConn()->executaSQL($_strSQL)!==false&&$this->_classe->getConn()->getNumRows()>0) {
			while($this->_classe->proximo()) {
				if(($_quebra=$this->_classe->processaQuebra())!==null) {
					if(is_array($_quebra)) {
						foreach($_quebra as $_linha) {
							$_tab->addSubtag($_linha);
						}
					} else {
						$_tab->addSubtag($_quebra);
					}
				}
				$this->_classe->processaRelatorio();
				$_tab->addSubtag(new tag($this->_tipos->getTipo('TR')));
				foreach($_camposrel as $_campo) {
					$_tab->getLastSubTag()->addSubTag(new tag($this->_tipos->getTipo('TD'),
												  Array($_campo->getAtributosExtras()),
												  $_campo->toPrint()));
				}
			}
			// Ultima Quebra
			if(($_quebra=$this->_classe->processaQuebra(true))!==null) {
				if(is_array($_quebra)) {
					foreach($_quebra as $_linha) {
						$_tab->addSubtag($_linha);
					}
				} else {
					$_tab->addSubtag($_quebra);
				}
			}
			// processamento do final do relatório, totais por exemplo
			if(($_footer=$this->_classe->posRelatorio())!==null) {
				foreach($_footer as $_res) {
					$_tab->addSubtag(new tag($this->_tipos->getTipo('TR')));
					foreach($_res[0] as $_k=>$_campo) {
						$_att = Array($_campo->getAtributosExtras());
						if($_res[1][$_k]!==null) {
							$_att[1] = $_res[1][$_k];
						} 
						$_tab->getLastSubTag()->addSubTag(new tag($this->_tipos->getTipo('TD'),
													  $_att,$_campo->toPrint()));
					}
				}
			}
			$_trf = new tag($this->_tipos->getTipo('TR'));
			$_trf->addSubTag(new tag($this->_tipos->getTipo("TD"),Array(new atributo("COLSPAN",sizeof($_camposrel)),
																  new atributo("STYLE","color:#a0a0a0;font-size:11px;border-top:1px solid #a0a0a0;")),
									 "Total de {$this->_classe->getConn()->getNumRows()} Registro(s)"));
			$_tab->addSubTag($_trf);
		} else {
			$_trf = new tag($this->_tipos->getTipo('TR'));
			$_trf->addSubTag(new tag($this->_tipos->getTipo("TD"),Array(new atributo("COLSPAN",sizeof($_camposrel)),
																  new atributo("STYLE","text-align:center"))," Nenhum Registro "));
			$_tab->addSubTag($_trf);
		}
		$this->getLastSubTag()->addSubTag($_tab);
		$this->addbotaoimpressao();
		return utf8_encode($this->toHTML(false));
	}
}
?>