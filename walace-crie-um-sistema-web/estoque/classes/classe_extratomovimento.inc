<?php
/**
 * Classe Extrato de movimentação
 */

class extratomovimento extends base {
	protected $_acumulado  = Array();
	protected $_data_atual = null;
	protected $_produto_atual = null;
	
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->_nome_tabela = 'historicomovimento';
		$this->_class_path = 'estoque';
		$this->addCampo(new string("PRODUTO_CODIGO","Produto Inicial",20,null,null,false,false,false,null,null,null,false,$_conn));
		$this->addCampo(new string("PRODUTO_CODIGO_F","Produto Final",20,null,null,false,false,false,null,null,null,false,$_conn));
		$this->addCampo(new string("PRODUTO_DESC","Descrição",60,null,null));
		$this->addCampo(new string("UNIDADE_CODIGO","Un",2,null,null));
		$this->addCampo(new data("HISTORICO_DATA","Data Inicial",10,null,null,false,false,false,null,null,null,false,$_conn));
		$this->addCampo(new data("HISTORICO_DATA_F","Data Final",10,null,null,false,false,false,null,null,null,false,$_conn));
		$this->addCampo(new string("LOCAL_DESC","Local",30,null,null));
		$this->addCampo(new string("TIPOMOV_DESC","Tipo de movimento",30,null,null));
		$this->addCampo(new string("TIPOMOV_TIPO","E/S",1,null,null));
		$this->addCampo(new string("HISTORICO_DOCUMENTO","Documento",20,null,null));
		$this->addCampo(new float("HISTORICO_QUANTIDADE","Quantidade",10,null,null));
		$this->addCampo(new dinheiro("HISTORICO_VALOR_UNIT","Unitário",12,null,null));
		$this->addCampo(new dinheiro("HISTORICO_VALOR_TOTAL","Total",12,null,null));
		// Fitros
		$this->getCampo("LOCAL_DESC")->setFiltro(false);
		$this->getCampo("PRODUTO_DESC")->setFiltro(false);
		$this->getCampo("UNIDADE_CODIGO")->setFiltro(false);
		$this->getCampo("TIPOMOV_DESC")->setFiltro(false);
		$this->getCampo("TIPOMOV_TIPO")->setFiltro(false);
		$this->getCampo("HISTORICO_DOCUMENTO")->setFiltro(false);
		$this->getCampo("HISTORICO_QUANTIDADE")->setFiltro(false);
		$this->getCampo("HISTORICO_VALOR_UNIT")->setFiltro(false);
		$this->getCampo("HISTORICO_VALOR_TOTAL")->setFiltro(false);
		//
		$this->getCampo("PRODUTO_CODIGO")->setRelatorio(false);
		$this->getCampo("PRODUTO_CODIGO_F")->setRelatorio(false);
		$this->getCampo("PRODUTO_DESC")->setRelatorio(false);
		$this->getCampo("UNIDADE_CODIGO")->setRelatorio(false);
		$this->getCampo("HISTORICO_DATA_F")->setRelatorio(false);
		$this->getCampo("PRODUTO_CODIGO")->setComportamento_form('ajax');
		$this->getCampo("PRODUTO_CODIGO")->setClasse("produto");
		$this->getCampo("PRODUTO_CODIGO")->setArquivo_Classe("estoque/classes/classe_produto.inc");
		$this->getCampo("PRODUTO_CODIGO_F")->setComportamento_form('ajax');
		$this->getCampo("PRODUTO_CODIGO_F")->setClasse("produto");
		$this->getCampo("PRODUTO_CODIGO_F")->setArquivo_Classe("estoque/classes/classe_produto.inc");
	}

	/**
	 * Sempre executamos o módulo de relatório especial
	 *
	 */
	public function processaAcao() {
		$this->geraFormularioFiltroRelatorio();
	}
	
	/**
	 * Uma classe de relatórios deve sempre montar seu select
	 *
	 */
	public function montaSELECT($_campos,$_where=null,$_orderby=null,$_limit=null,$_extras=null) {
		$this->getCampo("PRODUTO_CODIGO")->setTitulo("Produto");
		$this->getCampo("HISTORICO_DATA")->setTitulo("Data");
		$_strSQL=	"SELECT H.*,P.PRODUTO_DESC,P.UNIDADE_CODIGO," . 
					"L.LOCAL_DESC,T.TIPOMOV_DESC " . 
					"FROM {$this->_nome_tabela} H " . 
					"LEFT JOIN PRODUTO P ON H.PRODUTO_CODIGO=P.PRODUTO_CODIGO " . 
					"LEFT JOIN LOCALESTOQUE L ON H.LOCAL_CODIGO=L.LOCAL_CODIGO " . 
					"LEFT JOIN TIPOMOVIMENTO T ON H.TIPOMOV_CODIGO=T.TIPOMOV_CODIGO ";
		// Filtro
		$_where = Array();
		$_operador = Array('PRODUTO_CODIGO'=>'>=','PRODUTO_CODIGO_F'=>'<=',
						   'HISTORICO_DATA'=>'>=','HISTORICO_DATA_F'=>'<=',);
		$_alias    = Array('PRODUTO_CODIGO_F'=>'PRODUTO_CODIGO','HISTORICO_DATA_F'=>'HISTORICO_DATA');
		foreach($this->filtrarCampos("filtro") as $_nome=>$_campo) {
			if($_POST[$_nome]!=""&&$_POST[$_nome]!="TODOS") {
				$_campo->setValor($_POST[$_nome]);
				$_where[] = "H." . (array_key_exists($_nome,$_alias) ? $_alias[$_nome] : $_nome) . 
							(array_key_exists($_nome,$_operador) ? $_operador[$_nome] : '=') . 
							$_campo->toBD();
			}
		}
		if(sizeof($_where)>0) {
			$_strSQL .= " WHERE " . implode(" AND ",$_where) . " ";
		}
		$_strSQL .=	"ORDER BY H.PRODUTO_CODIGO,H.HISTORICO_DATA,H.HISTORICO_SEQUENCIA";
		return $_strSQL;
	}
	
	/**
	 * Devemos pre processar o relatório antes de ser gerado o html
	 *
	 */
	public function processaRelatorio() {
		// Vamos acumular os valores
		if($this->getCampo("TIPOMOV_TIPO")->getValor()=='E') {
			$this->_acumulado['TOTAL_ENTRADAS'] += $this->getCampo('HISTORICO_QUANTIDADE')->getValor();
			$this->_acumulado['TOTAL_VALOR'] += $this->getCampo('HISTORICO_VALOR_TOTAL')->getValor();
		} else {
			$this->_acumulado['TOTAL_SAIDAS'] += $this->getCampo('HISTORICO_QUANTIDADE')->getValor();
			$this->_acumulado['TOTAL_VALOR'] -= $this->getCampo('HISTORICO_VALOR_TOTAL')->getValor();
		}
		if($this->_data_atual==$this->getCampo("HISTORICO_DATA")->getValor()) {
			$this->getCampo("HISTORICO_DATA")->setValor("");
		} else {
			$this->_data_atual = $this->getCampo("HISTORICO_DATA")->getValor();
		}
	}
	
	public function processaQuebra($_fim=false) {
		if($this->_produto_atual!=$this->getCampo("PRODUTO_CODIGO")->getValor()||$_fim===true) {
			$_tags = Array();
			if($this->_produto_atual!==null||$_fim===true) {
				// Totais do anterior
				$_tr = new tag(new tipotag('TR'));
				$_tr->addSubTag(new tag(new tipotag("TD"),
								Array(new atributo("COLSPAN",2),
									  new atributo("STYLE",
												   "COLOR:#A0A0A0;FONT-WEIGHT:Bold;HEIGHT:25px;" . 
												   "border-top:1px solid black;border-bottom:1px solid black;")),
								"Totais"));
				$_tr->addSubTag(new tag(new tipotag("TD"),
								Array(new atributo("STYLE",
												   "COLOR:#A0A0A0;FONT-WEIGHT:Bold;HEIGHT:25px;text-align:right;" . 
												   "border-top:1px solid black;border-bottom:1px solid black;")),
								"Entradas:"));
				$_tr->addSubTag(new tag(new tipotag("TD"),
								Array(new atributo("STYLE",
												   "COLOR:#A0A0A0;FONT-WEIGHT:Bold;HEIGHT:25px;text-align:right;" . 
												   "border-top:1px solid black;border-bottom:1px solid black;")),
								number_format($this->_acumulado['TOTAL_ENTRADAS'],3,",",".")));
				$_tr->addSubTag(new tag(new tipotag("TD"),
								Array(new atributo("STYLE",
												   "COLOR:#A0A0A0;FONT-WEIGHT:Bold;HEIGHT:25px;text-align:right;" . 
												   "border-top:1px solid black;border-bottom:1px solid black;")),
								"Saídas:"));
				$_tr->addSubTag(new tag(new tipotag("TD"),
								Array(new atributo("STYLE",
												   "COLOR:#A0A0A0;FONT-WEIGHT:Bold;HEIGHT:25px;text-align:right;" . 
												   "border-top:1px solid black;border-bottom:1px solid black;")),
								number_format($this->_acumulado['TOTAL_SAIDAS'],3,",",".")));
				$_tr->addSubTag(new tag(new tipotag("TD"),
								Array(new atributo("STYLE",
												   "COLOR:#A0A0A0;FONT-WEIGHT:Bold;HEIGHT:25px;text-align:right;" . 
												   "border-top:1px solid black;border-bottom:1px solid black;")),
								"Saldo Valor:"));
				$_tr->addSubTag(new tag(new tipotag("TD"),
								Array(new atributo("STYLE",
												   "COLOR:#A0A0A0;FONT-WEIGHT:Bold;HEIGHT:25px;text-align:right;" . 
												   "border-top:1px solid black;border-bottom:1px solid black;")),
								number_format($this->_acumulado['TOTAL_VALOR'],2,",",".")));
				$_tags[] = $_tr;				
			}
			// Cabeçalho do produto
			if($_fim!==true) {
				$_tr = new tag(new tipotag('TR'));
				$_tr->addSubTag(new tag(new tipotag("TD"),
								Array(new atributo("COLSPAN",7),
									  new atributo("STYLE","COLOR:Navy;FONT-WEIGHT:Bold;HEIGHT:25px;")),
								"{$this->getCampo("PRODUTO_CODIGO")->getValor()}-" . 
								"{$this->getCampo("PRODUTO_DESC")->toHTML()}, " . 
								"UN:{$this->getCampo("UNIDADE_CODIGO")->getValor()}"));
				$this->_produto_atual = $this->getCampo("PRODUTO_CODIGO")->getValor();
				$this->_acumulado['TOTAL_ENTRADAS'] = 0;
				$this->_acumulado['TOTAL_SAIDAS']   = 0;
				$this->_acumulado['TOTAL_VALOR']    = 0;
				$this->_data_atual = null;
				$_tags[] = $_tr;
			}
			return $_tags;
		} else {
			return null;
		}
	}
	
}
?>