<?php
/**
 * Classe Fichas de inventario
 */

class fichainventario extends base {
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->_nome_tabela = 'inventarioproduto';
		$this->_class_path = 'estoque';
		$this->addCampo(new string("INVENTARIO_CODIGO","Inventário",10,null,null,true,false,true,1,null,null,false,$_conn));
		$this->addCampo(new string("MODO","Somente Divergentes",1,null,null,false,false,true,1,null,null,false,$_conn));
		$this->addCampo(new inteiro("INVENTARIO_CONTAGEM","Contagem atual",1,null,null,false,false,false,1,null,null,false));
		$this->addCampo(new string("PRODUTO","Produto",60,null,null,true,false,true,1,null,null,true,$_conn));
		$this->addCampo(new string("UNIDADE_CODIGO","Unidade",2,null,null,true,false,true,1,null,null,true,$_conn));
		$this->addCampo(new string("LOCAL","Local",40,null,null,false,false,true,1,null,null,true,$_conn));
		
		$this->getCampo("INVENTARIO_CODIGO")->setComportamento_form('select');
		$this->getCampo("MODO")->setComportamento_form('checkbox');
		$this->getCampo("MODO")->setValor_fixo('D');
		$this->getCampo("MODO")->setMarcar(false);
		$this->getCampo("INVENTARIO_CONTAGEM")->setFiltro(false);
		$this->getCampo("LOCAL")->setFiltro(false);
		$this->getCampo("PRODUTO")->setFiltro(false);
		$this->getCampo("UNIDADE_CODIGO")->setFiltro(false);
	}
	
	/**
	 * Sempre executamos o módulo de relatório especial
	 *
	 */
	public function processaAcao() {
		// Sempre mostra o filtro do relatório nada mais...
		$_inv = new inventario($this->_conn);
		$this->getCampo("INVENTARIO_CODIGO")->setValor_fixo($_inv->buscaLiberadosFicha());
		$this->geraFormularioFiltroRelatorio();
	}

	/**
	 * Uma classe de relatórios deve sempre montar seu select
	 *
	 */
	public function montaSELECT($_campos,$_where=null,$_orderby=null,$_limit=null,$_extras=null) {
		$_strSQL=	"SELECT I.INVENTARIO_CODIGO||' - '||I.INVENTARIO_DESC AS INVENTARIO_CODIGO,I.INVENTARIO_CONTAGEM," . 
					"P.PRODUTO_CODIGO||' - '||P.PRODUTO_DESC AS PRODUTO,P.UNIDADE_CODIGO," . 
					"L.LOCAL_CODIGO||' - '||L.LOCAL_DESC AS LOCAL " . 
					"FROM {$this->_nome_tabela} IP " . 
					"LEFT JOIN INVENTARIO I ON IP.INVENTARIO_CODIGO=I.INVENTARIO_CODIGO " . 
					"LEFT JOIN PRODUTO P ON IP.PRODUTO_CODIGO=P.PRODUTO_CODIGO " . 
					"LEFT JOIN LOCALESTOQUE L ON IP.LOCAL_CODIGO=L.LOCAL_CODIGO ";
		// Filtro
		$_strSQL .= " WHERE IP.INVENTARIO_CODIGO='{$_POST['INVENTARIO_CODIGO']}'";
		if($_POST['MODO']=='D') {
			$_strSQL .= " AND (IP.INVENTARIO_ESTOQUE<>IP.PRODUTO_ESTOQUE OR " . 
						"IP.INVENTARIO_ESTOQUE ISNULL)";
		}
		$_strSQL .=	" ORDER BY IP.PRODUTO_CODIGO";
		return $_strSQL;
	}

	
	/**
	 * Gera o cabeçalho inicial do sistema
	 *
	 */
	protected function addCabecalho() {
		$this->_html = new tag(new tipotag("HTML"));
		$this->_html->addSubTag(new tag(new tipotag("HEAD")));
		$this->_html->getLastSubTag()->addSubTag(new tag(new tipotag("TITLE"),null,"Sistema WEB"));
		$this->_html->addSubTag(new tag(new tipotag("BODY"),Array(new atributo("WIDTH","1010"))));
	}
	
	/**
	 * Impressão do relatório
	 *
	 */
	public function imprimirRelatorioEspecial() {
		$this->addCabecalho();
		// Imprime o Relatório
		$_tabela    = new tag(new tipotag("TABLE"),Array(new atributo("BORDER",0),new atributo("CELLPADDING",0),new atributo("CELLSPACING",0)));
		$_colunas   = null;
		if($this->_conn->executaSQL($this->montaSELECT(""))!==false&&$this->_conn->getNumRows()>0) {
			while($this->proximo()) {
				if($_colunas>=3||$_colunas===null) {
					if($_colunas!==null) {
						$_tabela->addSubTag(new tag(new tipotag("TR")));
						$_tabela->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),Array(new atributo("HEIGHT","20")),"&nbsp;"));
					}
					$_tabela->addSubTag(new tag(new tipotag("TR")));
					$_colunas = 1;
				}
				++$_colunas;
				$_tabela->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),Array(new atributo("WIDTH","520"))));
				$_tab_int = new tag(new tipotag("TABLE"),Array(new atributo("BORDER",0),
															new atributo("CELLSPACING",0),
															new atributo("CELLPADDING",0),
															new atributo("STYLE","width:100%;border:1px solid black;padding:5px;")));
				// Cabeçalho
				$_tab_int->addSubTag(new tag(new tipotag("TR")));
				$_tab_int->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),Array(new atributo("STYLE","vertical-align:top;padding-left:5px;"))));
				$_tab_int->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("IMG",false),
																			Array(new atributo("SRC","framework/imagens/logo.png"),
																				  new atributo("BORDER",0),
																				  new atributo("ALIGN","BOTTOM"),
																				  new atributo("WIDTH",60))));		
				$_tab_int->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
														Array(new atributo("ROWSPAN",2),new atributo("STYLE","border:1px solid black;width:15%;"))));
				$_tab_int->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("DIV"),
														Array(new atributo("STYLE","text-align:center;background-color:black;color:white;")),
														"Contagem"));
				$_tab_int->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("DIV"),
														Array(new atributo("STYLE","font-size:48px;text-align:center;font-weight:bold;")),
														$this->getCampo("INVENTARIO_CONTAGEM")->toPrint()));

				$_tab_int->addSubTag(new tag(new tipotag("TR")));
				$_tab_int->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
														Array(new atributo("STYLE","vertical-align:top;width:85%;text-align:left;font-size:14px;font-weight:bold;")),
														$this->getCampo("INVENTARIO_CODIGO")->toPrint()));
				$_tab_int->getLastSubTag()->addSubTag(new tag(new tipotag("TD")));
				// Produto + Local
				$_tab_int->addSubTag(new tag(new tipotag("TR")));
				$_tab_int->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),Array(new atributo("COLSPAN",2),new atributo("STYLE","padding-bottom:10px;")),"Produto<br>"));
				$_tab_int->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("SPAN"),
														Array(new atributo("STYLE","font-size:14px;font-weight:bold;")),
														$this->getCampo("PRODUTO")->toPrint() . " - " . $this->getCampo("UNIDADE_CODIGO")->toPrint()));

				// Quantidade
				$_tab_int->addSubTag(new tag(new tipotag("TR")));
				$_tab_int->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),Array(new atributo("COLSPAN",2))));
				$_tab_int->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("TABLE"),
														Array(new atributo("WIDTH","100%"),new atributo("CELLSPACING",0),new atributo("CELLPADDING",0))));
				$_tab_int->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("TR")));
				$_tab_int->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
														Array(new atributo("WIDTH","40%"),new atributo("VALIGN","TOP")),"Local<br>"));
				$_tab_int->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("SPAN"),
														Array(new atributo("STYLE","font-size:14px;font-weight:bold;")),
														$this->getCampo("LOCAL")->toPrint()));
				$_tab_int->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
														Array(new atributo("ALIGN","RIGHT"),
															  new atributo("STYLE","border:1px solid black;vertical-align:top;width:60%;height:70px;"))));
				$_tab_int->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("DIV"),
														Array(new atributo("STYLE","text-align:center;vertical-align:top;background-color:black;color:white;")),
														"Quantidade Inventariada"));
				$_tabela->getLastSubTag()->getLastSubTag()->addSubTag($_tab_int);
				if($_colunas==2) {
					$_tabela->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),Array(new atributo("WIDTH","20"))));
				}
			}
		} else {
			$this->_html->setValor(" * Nenhum Registro *");
		}
		$this->_html->getLastSubTag()->addSubTag($_tabela);
		$this->addbotaoimpressao();
		echo utf8_encode($this->_html->toHTML());
	}
	
	/**
	 * Adiciona o botão de impressão do relaório
	 *
	 */
	protected function addbotaoimpressao() {
		$this->_html->addSubTag(new tag(new tipotag("DIV"),
						Array(new atributo("ID","DIVPRINT"),
							  new atributo("STYLE","padding:10px;text-align:right;"))));
		$this->_html->getLastSubTag()->addSubTag(new tag(new tipotag("IMG",false),
						Array(new atributo("SRC","framework/imagens/print.png"),
							  new atributo("BORDER",0),
							  new atributo("ID","BTN_PRINT"),
							  new atributo("TITLE","Imprimir"),
							  new atributo("STYLE","cursor:pointer"),
							  new atributo("ONCLICK","this.parentNode.style.display='none';window.print();" . 
							  						 "var obj=this;setTimeout(function(){obj.parentNode.style.display='block';},3000);")
		)));
	}
}
?>