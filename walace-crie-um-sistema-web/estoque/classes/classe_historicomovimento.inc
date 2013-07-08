<?php
/**
 * Classe historicomovimento
 */

class historicomovimento extends base {
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->_nome_tabela = 'historicomovimento';
		$this->_class_path = 'estoque';
		$this->addCampo(new string("PRODUTO_CODIGO","Produto",20,null,null,true,false,true,1,null,null,true,$_conn));
		$this->addCampo(new string("PRODUTO_DESC","Descrição",60,null,null,true,false,false,1,null,null,false,$_conn));
		$this->addCampo(new float("PRODUTO_ESTOQUE","Estoque Atual",12,null,null,true,false,false,null,null,null,false));
		$this->addCampo(new float("PRODUTO_CUSTOMEDIO","Custo Médio",12,null,null,true,false,false,null,null,null,false));
		$this->addCampo(new string("LOCAL_CODIGO","Local",10,null,null,true,false,true,1,null,null,true,$_conn));
		$this->addCampo(new float("LOCAL_ESTOQUE","Estoque do Local",12,null,null,true,false,false,null,null,null,false));
		$this->addCampo(new inteiro("HISTORICO_SEQUENCIA","Sequência",15,null,null,false,false,true,1,null,null,true));
		$this->addCampo(new string("TIPOMOV_CODIGO","Tipo de movimento",10,null,null,true,false,false,1,null,null,false,$_conn));
		$this->addCampo(new data("HISTORICO_DATA","Data",10,null,null,true,true,true,null,'NOW',null,true,$_conn));
		$this->addCampo(new string("TIPOMOV_TIPO","Entrada/Saída",1,null,null,false,false,true,1,null,null,false,$_conn));
		$this->addCampo(new string("HISTORICO_DOCUMENTO","Documento",20,null,null,true,true,true,1,null,null,false,$_conn));
		$this->addCampo(new float("HISTORICO_QUANTIDADE","Quantidade",10,null,null,true,false,true,0.001,null,null,false));
		$this->addCampo(new dinheiro("HISTORICO_VALOR_UNIT","Valor unitário",12,null,null,true,true,true,0,null,null,false));
		$this->addCampo(new dinheiro("HISTORICO_VALOR_TOTAL","Total",12,null,null,true,true,true,0,null,null,false));
		$this->addCampo(new string("HISTORICO_HISTORICO","Histórico",2000,null,null,true,false,false,1,null,null,false,$_conn));
		$this->addCampo(new string("HISTORICO_ESTORNO","Estorno?",1,null,null,false,false,true,1,null,null,false,$_conn));
		$this->addCampo(new inteiro("HISTORICO_ESTORNO_SEQ","Sequência Estornada",15,null,null,false,false,false,1,null,null,false));
		$this->addCampo(new string("HISTORICO_ESTORNADO","Estornado?",1,null,null,false,false,true,1,null,null,false,$_conn));
		$this->addCampo(new string("USUARIO_LOGIN","Usuário",20,null,null,false,false,false,null,null,null,false,$_conn));
		$this->addCampo(new datahora("DATA_ULTIMA_ALTERACAO","Data",14,null,null,false,false,false,null,null,null,false,$_conn));
		$this->getCampo("PRODUTO_CODIGO")->setComportamento_form("ajax");
		$this->getCampo("PRODUTO_CODIGO")->setClasse("produto");
		$this->getCampo("PRODUTO_CODIGO")->setArquivo_Classe("estoque/classes/classe_produto.inc");
		$this->getCampo("PRODUTO_CODIGO")->setUpdateElement("function(li) {atualizaFormulario(li);objBP.buscar();}");
		$this->getCampo("LOCAL_CODIGO")->setComportamento_form("select");
		$this->getCampo("TIPOMOV_CODIGO")->setComportamento_form("select");
		$this->getCampo("HISTORICO_HISTORICO")->setComportamento_form("textarea");	
		$this->_exibe_opcoes = false;	
		$this->_exibe_botao_incluir = true;
	}
	
	/**
	 * Busca a próxima sequencia disponivel retornando 1 caso nenhuma exista
	 *
	 * @return integer
	 */
	protected function buscaProximaSequencia() {
		if($this->_conn->executaSQL($this->montaSELECT("COALESCE(MAX(HISTORICO_SEQUENCIA),0)+1 AS SEQ"))!==false) {
			$_dados = $this->_conn->proximo();
			return (int) $_dados["SEQ"];
		}
		return 1;
	}
	
	/**
	 * Preenche a lista de valores para Tipo de mobivento
	 *
	 * @param string $_where
	 */
	protected function buscaTiposMovimentos($_where=null) {
		$_tm = new tipomovimento($this->_conn);
		$_tm->getConn()->executaSQL($_tm->montaSELECT("*",$_where));
		if($_tm->getConn()->getNumrows()<1) {
			die(utf8_encode("<span style='color:red;font-size:20px;text-align:center;'>É necessário ter pelo menos 1 Tipo de movimento cadastrado</span>"));
		}
		$_lc[] = Array("valor"=>"-","label"=>"selecione o Tipo de movimento");
		while($_tm->proximo()!==false) {
			$_lc[] = Array("valor"=>$_tm->getCampo('TIPOMOV_CODIGO')->getValor(),
							 "label"=>$_tm->getCampo('TIPOMOV_DESC')->getValor());
		}
		$this->getCampo("TIPOMOV_CODIGO")->setValor_fixo($_lc);
	}
	
	/**
	 * Ajusta o comportamento dos campos do formulário
	 *
	 * @param unknown_type $_nome
	 * @param tag $_campo
	 * @param unknown_type $_metodo
	 */
	protected function processaCampoFormulario($_nome,tag &$_campo,$_metodo) {
		if(stripos($_metodo,'getformulario')!==false) {
			switch($_nome) {
				case 'PRODUTO_CODIGO':		$_campo->addAtributo(new atributo("ONCHANGE","objBP.inicializa();"));
											break;
				case 'PRODUTO_DESC':
				case 'PRODUTO_ESTOQUE':
				case 'LOCAL_ESTOQUE':
				case 'HISTORICO_DOCUMENTO':
				case 'HISTORICO_HISTORICO':
				case 'HISTORICO_DATA':
				case 'PRODUTO_CUSTOMEDIO': 		$_campo->addAtributo(new atributo("DISABLED"));
												break;
				case 'LOCAL_CODIGO':			$_campo->addAtributo(new atributo("ONCHANGE","objBP.buscaLocal();"));
												break;
				case 'TIPOMOV_CODIGO':			$_campo->addAtributo(new atributo("ONCHANGE","objBP.validaTipomov();"));
												break;
				case 'HISTORICO_QUANTIDADE':
				case 'HISTORICO_VALOR_UNIT':
				case 'HISTORICO_VALOR_TOTAL':	$_campo->addAtributo(new atributo("ONCHANGE","recalculoValores(this)"));
												$_campo->addAtributo(new atributo("DISABLED"));
												break;
			}
		}
	}
	
	/**
	 * Retorna o comando SQL necessário para
	 * a busca do próximo código
	 *
	 * @return string
	 */
	public function montaSQLProximoCodigo() {
		return "SELECT MAX(HISTORICO_SEQUENCIA) AS CODIGO FROM {$this->_nome_tabela}";
	}

	/**
	 * Define uma nova ordem na lista retornada
	 *
	 * @return string
	 */
	public function getOrdem() {
		return "HISTORICO_SEQUENCIA DESC";
	}
	
	/**
	 * Ajustar os campos Usuário e data da
	 * última alteração antes de efetivar a transação
	 *
	 * @return mixed
	 */
	public function incluir() {
		$this->getCampo("HISTORICO_SEQUENCIA")->setValor($this->buscaProximaSequencia());
		$this->getCampo("HISTORICO_SEQUENCIA")->setIncluir(true);
		$this->setUsuarioeData();
		$this->_conn->startTransaction();
		if(($_res=parent::incluir())!==false) {
			// Acertar os Saldos
			$_prd = new produto($this->_conn);
			$_tpm = new tipomovimento($this->_conn);
			$_tpm->Buscar(Array('TIPOMOV_CODIGO'=>$this->getCampo("TIPOMOV_CODIGO")->getValor()));
			$_tpm->proximo();
			$_prd->Buscar(Array('PRODUTO_CODIGO'=>$this->getCampo("PRODUTO_CODIGO")->getValor()));
			$_prd->proximo();
			if(($_rp=$_prd->acertaEstoque($this->getCampo("HISTORICO_QUANTIDADE")->toBD(),
								 $this->getCampo("HISTORICO_VALOR_TOTAL")->toBD(),
								 $_tpm))!==false) {
				// Saldo do Local
				$_lce = new estoquelocal($this->_conn);
				$_lce->Buscar(Array('PRODUTO_CODIGO'=>$this->getCampo("PRODUTO_CODIGO")->getValor(),
									'LOCAL_CODIGO'=>$this->getCampo('LOCAL_CODIGO')->getValor()));
				if($_lce->getConn()->getNumRows()<=0) {
					// Criar o novo local
					$_re=$_lce->inicializaEstoqueLocal($this->getCampo('PRODUTO_CODIGO')->getValor(),$this->getCampo('LOCAL_CODIGO')->getValor());
				} else {
					$_lce->proximo();
					$_re = true;
				}
				if($_re!==false) {
					$_re=$_lce->acertaEstoque($this->getCampo("HISTORICO_QUANTIDADE")->toBD(),
									 		  $this->getCampo("HISTORICO_VALOR_TOTAL")->toBD(),
									 		  $_tpm);
				}
				if($_re!==false) {
					$this->_conn->commit();
				} else {
					$this->_conn->ROLLBACK();
					return $_re;
				}
			} else {
				$this->_conn->ROLLBACK();
				return $_rp;
			}
		} else {
			$this->_conn->ROLLBACK();
		}
		return $_res;
	}
	
	/**
	 * Não existe alteração no movimento
	 * Com exceção do Estorno
	 * 
	 * @return mixed
	 */
	public function Alterar() {
		return false;
	}
	
	public function getFormulario($_funcao='INC') {
		$_extra = "";
		// Buscar Locais 
		$_local = new localestoque($this->_conn);
		$_local->Buscar();
		if($_local->getConn()->getNumrows()<1) {
			die(utf8_encode("<span style='color:red;font-size:20px;text-align:center;'>É necessário ter pelo menos 1 Local cadastrado</span>"));
		}
		$_lc[] = Array("valor"=>"-","label"=>"selecione o Local");
		while($_local->proximo()!==false) {
			$_lc[] = Array("valor"=>$_local->getCampo('LOCAL_CODIGO')->getValor(),
							 "label"=>$_local->getCampo('LOCAL_DESC')->getValor());
		}
		$this->getCampo("LOCAL_CODIGO")->setValor_fixo($_lc);
		// Tipos de movimentos
		$this->buscaTiposMovimentos();
		// Carregar javascript especifico
		$_sc = new tag(new tipotag("SCRIPT"),null,"LoadJS('estoque/javascript/movimento.js');");
		$_extra = $_sc->toHTML();
		$this->_num_colunas_form = 2;
		return $_extra . parent::getFormulario($_funcao);
	}
	
}

/**
 * Classe para movimentação de entradas
 *
 */
class entradas extends historicomovimento {
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->getCampo("HISTORICO_VALOR_UNIT")->setMinimo(0.01);
		$this->getCampo("HISTORICO_VALOR_TOTAL")->setMinimo(0.01);
	}	
	
	/**
	 * Seleciona apenas os tipos de movimento de entrada
	 *
	 * @param string $_where
	 */
	protected function buscaTiposMovimentos($_where=null) {
		parent::buscaTiposMovimentos("TIPOMOV_TIPO='E' AND TIPOMOV_ESTORNO='N'");
	}

	protected function FiltroFixo() {
		return "TIPOMOV_TIPO='E'";
	}	

	/**
	 * Informa a classe javascript que é uma Entrada
	 *
	 * @param string $_funcao
	 * @return mixed
	 */
	public function getFormulario($_funcao='INC') {
		$_sc = new tag(new tipotag("SCRIPT"),null,"objBP.FEntrada=true;");
		return parent::getFormulario($_funcao) . $_sc->toHTML();
	}
	
}

/**
 * Classe para movimentação de saídas
 *
 */
class saidas extends historicomovimento {
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->getCampo("HISTORICO_VALOR_UNIT")->setMinimo(null);
		$this->getCampo("HISTORICO_VALOR_TOTAL")->setMinimo(null);
		$this->getCampo("HISTORICO_QUANTIDADE")->setMaximo('[LOCAL_ESTOQUE]');
		$this->addCampo(new float("CUSTO_SAIDA","",12,null,null,true,false,false,1,null,null,false));
		$this->getCampo("CUSTO_SAIDA")->setComportamento_form('hidden');
	}	

	/**
	 * Retorna somente os tipos de movimento de saída
	 *
	 * @param string $_where
	 */
	protected function buscaTiposMovimentos($_where=null) {
		parent::buscaTiposMovimentos("TIPOMOV_TIPO='S' AND TIPOMOV_ESTORNO='N'");
	}

	/**
	 * Informa a classe javascript que é uma saída
	 *
	 * @param string $_funcao
	 * @return mixed
	 */
	public function getFormulario($_funcao='INC') {
		$_sc = new tag(new tipotag("SCRIPT"),null,"objBP.FEntrada=false;");
		return parent::getFormulario($_funcao) . $_sc->toHTML();
	}
	
	protected function FiltroFixo() {
		return "TIPOMOV_TIPO='S'";
	}	
	
	public function incluir() {
		$this->getCampo("TIPOMOV_TIPO")->setValor('S');
		$this->getCampo("TIPOMOV_TIPO")->setIncluir(true);
		$this->getCampo("CUSTO_SAIDA")->setIncluir(false);
		$this->getCampo("HISTORICO_VALOR_UNIT")->setValor($this->getCampo("CUSTO_SAIDA")->getValor());
		$this->getCampo("HISTORICO_VALOR_TOTAL")->setValor($this->getCampo("CUSTO_SAIDA")->toBD()*$this->getCampo("HISTORICO_QUANTIDADE")->toBD());
		$this->getCampo("HISTORICO_VALOR_TOTAL")->setValor($this->getCampo("HISTORICO_VALOR_TOTAL")->toHTML());
		return parent::incluir();
	}

}

/**
 * Classe base para o Estorno de movimentos
 * Esta classe deve ser instanciada por outras classes
 *
 */
class estorno extends historicomovimento {
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->getCampo("HISTORICO_VALOR_UNIT")->setMinimo(null);
		$this->getCampo("HISTORICO_VALOR_TOTAL")->setMinimo(null);
		$this->getCampo("HISTORICO_SEQUENCIA")->setIncluir(true);
		// Criar campos auxiliares.. todos hidden
		$_arr = Array('PRODUTO'=>'string','LOCAL'=>'string','DATA'=>'data',
					  'SEQUENCIA'=>'inteiro','VALOR_UNITARIO'=>'float','QUANTIDADE'=>'float');
		foreach($_arr as $_campo=>$_tipo) {
			$this->addCampo(new $_tipo($_campo,"",1,null,null,true,false,false,null,null,null,false));
			if($_tipo=='string'||$_tipo=='data') {
				$this->getCampo($_campo)->SetConn($_conn);
			}
			$this->getCampo($_campo)->setComportamento_form('hidden');
		}
		$this->_exibe_opcoes = true;
	}	

	/**
	 * Teremos apenas a opção de estorno na lista
	 *
	 * @param string $_pk
	 * @param tag $_tab
	 * @param tipospadrao $_tipos
	 */
	protected function getOpcoesLista($_pk,tag & $_tab,tipospadrao $_tipos) {
			$_lnkalt = new tag($_tipos->getTipo("A"),Array(new atributo("HREF","javascript:void(0);"),
														   new atributo("ONCLICK","ObjProcAjax.run('{$_SERVER['PHP_SELF']}?ACAO=INC{$_pk}','CORPO');"))," Estornar ");
			$_tab->getLastSubTag()->addSubTag(new tag($_tipos->getTipo('TD'),
										  Array(new atributo("STYLE","border:1px solid #a0a0a0;")),$_lnkalt->toHTML()));
	}
	
	/**
	 * Desabilita todos os campos do formulário, exceto Tipo de movimento
	 *
	 * @param string $_nome
	 * @param tag $_campo
	 * @param string $_metodo
	 */
	protected function processaCampoFormulario($_nome,tag &$_campo,$_metodo) {
		if(stripos($_metodo,'getformulario')!==false) {
			switch($_nome) {
				case 'PRODUTO_CODIGO':
				case 'PRODUTO_DESC':
				case 'PRODUTO_ESTOQUE':
				case 'LOCAL_CODIGO':	
				case 'LOCAL_ESTOQUE':
				case 'HISTORICO_DOCUMENTO':
				case 'HISTORICO_SEQUENCIA':
				case 'HISTORICO_HISTORICO':
				case 'HISTORICO_DATA':
				case 'PRODUTO_CUSTOMEDIO':
				case 'HISTORICO_QUANTIDADE':
				case 'HISTORICO_VALOR_UNIT':
				case 'HISTORICO_VALOR_TOTAL':	$_campo->addAtributo(new atributo("DISABLED"));
												break;
				case 'TIPOMOV_CODIGO':			$_campo->addAtributo(new atributo("ONCHANGE","objBP.validaTipomov();"));
												break;
			}
		}
	}

	/**
	 * Ajusta o formulário de Estorno
	 *
	 * @param string $_funcao
	 * @return mixed
	 */
	public function getFormulario($_funcao='INC') {
		// Temos os dados de busca, precisamos recuperar o registro...
		if($this->Buscar(Array(
						'PRODUTO_CODIGO'=>$_GET['PRODUTO_CODIGO'],
						'LOCAL_CODIGO'=>$_GET['LOCAL_CODIGO'],
						'HISTORICO_DATA'=>$_GET['HISTORICO_DATA'],
						'HISTORICO_SEQUENCIA'=>$_GET['HISTORICO_SEQUENCIA']))===false) {
			die(utf8_encode("<span style='color:red;font-size:20px;text-align:center;'>Registro a Estornar não encontrado</span>"));
		}
		$this->proximo();
		if($this->getCampo("HISTORICO_ESTORNADO")=='S') {
			die(utf8_encode("<span style='color:red;font-size:20px;text-align:center;'>Movimento já estornado</span>"));
		}
		// Preencher
		$_sctxt = "document.getElementById('PRODUTO_CODIGO').value='{$_GET['PRODUTO_CODIGO']}';" . 
 				  "document.getElementById('LOCAL_CODIGO').value='{$_GET['LOCAL_CODIGO']}';" . 
				  "document.getElementById('HISTORICO_SEQUENCIA').value='{$_GET['HISTORICO_SEQUENCIA']}';" . 
				  "document.getElementById('HISTORICO_DATA').value='{$_GET['HISTORICO_DATA']}';" . 
				  "document.getElementById('PRODUTO').value='{$_GET['PRODUTO_CODIGO']}';" . 
				  "document.getElementById('LOCAL').value='{$_GET['LOCAL_CODIGO']}';" . 
				  "document.getElementById('SEQUENCIA').value='{$_GET['HISTORICO_SEQUENCIA']}';" . 
				  "document.getElementById('DATA').value='{$_GET['HISTORICO_DATA']}';" . 				  
				  "document.getElementById('HISTORICO_DOCUMENTO').value='';" . 
				  "document.getElementById('HISTORICO_QUANTIDADE').value='{$this->getCampo('HISTORICO_QUANTIDADE')->toHTML()}';" . 
				  "document.getElementById('QUANTIDADE').value='{$this->getCampo('HISTORICO_QUANTIDADE')->toHTML()}';" . 
				  "document.getElementById('HISTORICO_VALOR_UNIT').value='{$this->getCampo('HISTORICO_VALOR_UNIT')->toHTML()}';" . 
				  "document.getElementById('VALOR_UNITARIO').value='{$this->getCampo('HISTORICO_VALOR_UNIT')->toHTML()}';" . 
				  "document.getElementById('HISTORICO_VALOR_TOTAL').value='{$this->getCampo('HISTORICO_VALOR_TOTAL')->toHTML()}';" . 
				  "document.getElementById('HISTORICO_HISTORICO').innerHTML='Estorno do Documento:{$this->getCampo('HISTORICO_DOCUMENTO')->toHTML()}';";
		// Buscar Dados do produto e do local de estoque
		$_prd = new produto($this->_conn);
		$_prd->Buscar(Array('PRODUTO_CODIGO'=>$_GET['PRODUTO_CODIGO']));
		$_prd->proximo();
		$_sctxt .= "document.getElementById('PRODUTO_DESC').value='{$_prd->getCampo('PRODUTO_DESC')->toHTML()}';" . 
				   "document.getElementById('PRODUTO_ESTOQUE').value='{$_prd->getCampo('PRODUTO_ESTOQUE')->toHTML()}';" . 
				   "document.getElementById('PRODUTO_CUSTOMEDIO').value='{$_prd->getCampo('PRODUTO_CUSTOMEDIO')->toHTML()}';";
		$_lcl = new estoquelocal($this->_conn);
		$_lcl->Buscar(Array('PRODUTO_CODIGO'=>$_GET['PRODUTO_CODIGO'],'LOCAL_CODIGO'=>$_GET['LOCAL_CODIGO']));
		$_lcl->proximo();
		$_sctxt .= "document.getElementById('LOCAL_ESTOQUE').value='{$_lcl->getCampo('PRODUTO_ESTOQUE')->toHTML()}';";
		$_sc = new tag(new tipotag("SCRIPT"),null,"objBP.FEstorno=true;{$_sctxt}");
		return parent::getFormulario($_funcao) . $_sc->toHTML();
	}

	
	/**
	 * Não teremos o botão incluir nesta lista
	 *
	 * @param tag $_div
	 * @param tipospadrao $_tipos
	 */
	protected function getBotaoIncluir(tag & $_div,tipospadrao $_tipos) {
	}
	
	/**
	 * Ajusta os campos da classe antes de inlcuir
	 *
	 * @return mixed
	 */
	public function incluir() {
		$this->getCampo("HISTORICO_ESTORNO_SEQ")->setIncluir(true);
		$this->getCampo("HISTORICO_ESTORNO")->setIncluir(true);
		$this->getCampo("HISTORICO_ESTORNO_SEQ")->setValor($this->getCampo("SEQUENCIA")->getValor());
		$this->getCampo("HISTORICO_ESTORNO")->setValor('S');
		$_arr = Array('PRODUTO'=>'PRODUTO_CODIGO','LOCAL'=>'LOCAL_CODIGO','DATA'=>'DATA','SEQUENCIA'=>'SEQUENCIA',
					  'QUANTIDADE'=>'HISTORICO_QUANTIDADE','VALOR_UNITARIO'=>'HISTORICO_VALOR_UNIT');
		foreach($_arr as $_alias=>$_campo) {
			$this->getCampo($_campo)->setValor($this->getCampo($_alias)->getValor());
			$this->getCampo($_alias)->setIncluir(false);
		}
		$this->getCampo("HISTORICO_VALOR_TOTAL")->setValor($this->getCampo("HISTORICO_VALOR_UNIT")->toBD()*$this->getCampo("HISTORICO_QUANTIDADE")->toBD());
		$this->getCampo("HISTORICO_VALOR_TOTAL")->setValor($this->getCampo("HISTORICO_VALOR_TOTAL")->toHTML());
		if(($_res=parent::incluir())!==false) {
			// Marcar o Movimento estornado para não aparecer mais na lista
			$_strSQL = "UPDATE {$this->_nome_tabela} SET HISTORICO_ESTORNADO='S' WHERE " . 
					   "PRODUTO_CODIGO={$this->getCampo('PRODUTO_CODIGO')->toBD()} AND " . 
					   "LOCAL_CODIGO={$this->getCampo('LOCAL_CODIGO')->toBD()} AND " . 
					   "HISTORICO_DATA={$this->getCampo('HISTORICO_DATA')->toBD()} AND " . 
					   "HISTORICO_SEQUENCIA={$this->getCampo('HISTORICO_ESTORNO_SEQ')->toBD()}";
			$this->_conn->executaSQL($_strSQL);
		}		
		return $_res;
	}
	
}

/**
 * Classe para o estorno de entradas de estoque
 *
 */
class estornoentrada extends estorno {
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->getCampo("HISTORICO_QUANTIDADE")->setMaximo('[LOCAL_ESTOQUE]');
	}

	/**
	 * Define o filtro como Entrada + Não Estornado
	 *
	 * @return string
	 */
	protected function FiltroFixo() {
		return "TIPOMOV_TIPO='E' AND HISTORICO_ESTORNADO='N'";
	}	
	
	/**
	 * Ajusta o tipo de movimento para 'S'
	 * Uma vez que o estorno de uma entrada é uma saida
	 *
	 * @return mixed
	 */
	public function incluir() {
		$this->getCampo("TIPOMOV_TIPO")->setValor('S');
		$this->getCampo("TIPOMOV_TIPO")->setIncluir(true);
		return parent::incluir();
	}
	
	/**
	 * Retorna somente tipos de movimentos que sejam um estorno de entrada
	 *
	 * @param string $_where
	 */
	protected function buscaTiposMovimentos($_where=null) {
		parent::buscaTiposMovimentos("TIPOMOV_TIPO='S' AND TIPOMOV_ESTORNO='S'");
	}
}

/**
 * Classe para o estorno de saídas de estoque
 *
 */
class estornosaida extends estorno {
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
	}

	/**
	 * Define o filtro como Saída + Não Estornado
	 *
	 * @return string
	 */
	protected function FiltroFixo() {
		return "TIPOMOV_TIPO='S' AND HISTORICO_ESTORNADO='N'";
	}	
	
	/**
	 * Ajusta o tipo de movimento para 'E'
	 * Uma vez que o estorno de uma saida é uma entrada
	 *
	 * @return mixed
	 */
	public function incluir() {
		$this->getCampo("TIPOMOV_TIPO")->setValor('E');
		$this->getCampo("TIPOMOV_TIPO")->setIncluir(true);
		return parent::incluir();
	}
	
	/**
	 * Retorna somente tipos de movimentos que sejam um estorno de saída
	 *
	 * @param string $_where
	 */
	protected function buscaTiposMovimentos($_where=null) {
		parent::buscaTiposMovimentos("TIPOMOV_TIPO='E' AND TIPOMOV_ESTORNO='S'");
	}
}
?>