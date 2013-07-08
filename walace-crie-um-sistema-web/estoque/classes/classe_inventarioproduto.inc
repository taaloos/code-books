<?php
/**
 * Classe itens do inventario
 */
class inventarioproduto extends base {
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->_nome_tabela = 'inventarioproduto';
		$this->_class_path = 'estoque';
		$this->addCampo(new string("INVENTARIO_CODIGO","Inventário",10,null,null,true,false,true,1,null,null,true,$_conn));
		$this->addCampo(new string("PRODUTO_CODIGO","Produto",20,null,null,true,false,true,1,null,null,true,$_conn));
		$this->addCampo(new string("PRODUTO_DESC","Descrição produto",60,null,null,false,false,true,null,null,null,false,$_conn));
		$this->addCampo(new string("LOCAL_CODIGO","Local",10,null,null,false,false,true,1,null,null,true,$_conn));
		$this->addCampo(new string("LOCAL_DESC","Descrição local",30,null,null,false,false,true,null,null,null,false,$_conn));
		$this->addCampo(new float("PRODUTO_ESTOQUE","Estoque Atual",12,null,null,false,true,true,0.001,null,null,false));
		$this->addCampo(new dinheiro("PRODUTO_CUSTOMEDIO","Custo médio",12,null,null,false,true,false,0,null,null,false));
		$this->addCampo(new float("INVENTARIO_ESTOQUE","Inventariado",12,null,null,false,false,true,0.001,null,null,false));
		$this->addCampo(new string("USUARIO_LOGIN","Usuário",20,null,null,false,false,false,null,null,null,false,$_conn));
		$this->addCampo(new datahora("DATA_ULTIMA_ALTERACAO","Data",14,null,null,false,false,false,null,null,null,false,$_conn));
		$this->addCampo(new string("ITENS","",1,null,null,true,false,false,null,null,null,false,$_conn));
		$this->addCampo(new string("INVENTARIO","",10,null,null,true,false,false,null,null,null,false,$_conn));
		$this->getCampo("PRODUTO_CODIGO")->setComportamento_form('ajax');
		$this->getCampo("PRODUTO_CODIGO")->setClasse("produto");
		$this->getCampo("PRODUTO_CODIGO")->setArquivo_Classe("estoque/classes/classe_produto.inc");
		$this->getCampo("INVENTARIO")->setComportamento_form('hidden');
		$this->getCampo("ITENS")->setComportamento_form('hidden');
		$this->getCampo("ITENS")->setValor_Fixo('S');
	}
	
	
	/**
	 * Ajusta o comportamento dos campos do formulário
	 *
	 */
	protected function processaCampoFormulario($_nome,tag &$_campo,$_metodo) {
		if(stripos($_metodo,'getformulario')!==false) {
			switch($_nome) {
				case 'INVENTARIO_CODIGO':	$_campo->addAtributo(new atributo("DISABLED"));
											break;
			}
		}
	}
	
	/**
	 * Reescrito
	 *
	 */
	public function montaSELECT($_campos,$_where=null,$_orderby=null,$_limit=null,$_extras=null) {
		if(func_num_args()==6&&(func_get_arg(5)=='listar'||func_get_arg(5)=='relatorio')) {
			return 	"SELECT INVENTARIO_CODIGO,I.PRODUTO_CODIGO,P.PRODUTO_DESC," . 
					"I.LOCAL_CODIGO,L.LOCAL_DESC," . 
					"I.PRODUTO_ESTOQUE,I.PRODUTO_CUSTOMEDIO,I.INVENTARIO_ESTOQUE " . 
					"FROM {$this->_nome_tabela} I " .
					"LEFT JOIN PRODUTO P ON I.PRODUTO_CODIGO=P.PRODUTO_CODIGO " . 
					"LEFT JOIN LOCALESTOQUE L ON I.LOCAL_CODIGO=L.LOCAL_CODIGO " .  
					($_where!==null ? "WHERE {$_where}" : "") .
					($_orderby!==null ? " ORDER BY {$_orderby}" : "") . 
					($_extras!==null ? " {$_extras}" : "") . 
					($_limit!==null ? " LIMIT {$_limit}" : ""); 
		} else {
			return parent::montaSELECT($_campos,$_where,$_orderby,$_limit,$_extras);
		}
	}
	
	/**
	 * Apenas os itens do inventário selecionado
	 *
	 * @return string
	 */
	public function FiltroFixo() {
		return "(INVENTARIO_CODIGO='{$_GET['INVENTARIO_CODIGO']}') ";
	}
	
	
	/**
	 * Conforme o parametro de geração do inventário
	 * deve-se gerar o mesmo produto para todos os locais
	 * definidos no gerador do inventário
	 * Ajustar os campos Usuário e data da
	 * última alteração antes de efetivar a transação
	 *
	 * @return mixed
	 */
	public function incluir() {
		$this->getCampo("INVENTARIO_CODIGO")->setValor($_POST['INVENTARIO']);
		$this->getCampo("INVENTARIO_CODIGO")->setIncluir(true);
		$this->getCampo("LOCAL_CODIGO")->setIncluir(true);
		$this->getCampo("INVENTARIO")->setIncluir(false);
		$this->getCampo("ITENS")->setIncluir(false);
		$_GET['INVENTARIO_CODIGO'] = $this->getCampo("INVENTARIO_CODIGO")->getValor();
		$_GET['ITENS'] = 'S'; 
		$_POST['SCRIPT_NAME'] .= "?ITENS=S&INVENTARIO_CODIGO={$_GET['INVENTARIO_CODIGO']}";
		$this->setUsuarioeData();
		$_strSQL = "SELECT L.LOCAL_CODIGO FROM LOCALESTOQUE L " .
					"LEFT JOIN INVENTARIO I " . 
					"ON (I.LOCAL_CODIGO='TODOS' OR L.LOCAL_CODIGO=I.LOCAL_CODIGO) " . 
					"WHERE I.INVENTARIO_CODIGO='{$_POST['INVENTARIO']}'"; 
		$_locais = null;
		if($this->_conn->executaSQL($_strSQL)!==false&&$this->_conn->getNumRows()>0) {
			while($_dados=$this->_conn->proximo()) {
				$_locais[] = $_dados['LOCAL_CODIGO'];
			}
		}
		if($_locais===null) {
			return false;
		} else {
			$this->_conn->startTransaction();
			foreach($_locais as $_local) {
				$this->getCampo("LOCAL_CODIGO")->setValor($_local);
				if(($_res=parent::incluir())===false) {
					$this->_conn->ROLLBACK();
					return $_res;
				}
			}
			$this->_conn->commit();
			return $_res;
		}
	}
	
	/**
	 * Devemos excluir todos os produtos do mesmo inventário
	 *
	 */
	public function Excluir() {
		$this->getCampo("LOCAL_CODIGO")->setPk(false);
		$_GET['INVENTARIO_CODIGO'] = $this->getCampo("INVENTARIO_CODIGO")->getValor();
		$_GET['ITENS'] = 'S'; 
		$_POST['SCRIPT_NAME'] .= "?ITENS=S&INVENTARIO_CODIGO={$_GET['INVENTARIO_CODIGO']}";
		return parent::excluir();
	}
	
	public function getFormulario($_funcao='INC') {
		$this->getCampo("INVENTARIO_CODIGO")->setValor($_GET['INVENTARIO_CODIGO']);
		$this->getCampo("INVENTARIO")->setValor_Fixo($_GET['INVENTARIO_CODIGO']);
		return parent::getFormulario($_funcao);
	}

	/**
	 * Gera as opções na lista de registros
	 * Na forma padrão, gera os links para Alterar e Excluir
	 *
	 * @param string $_pk
	 * @param tag $_tab
	 */
	protected function getOpcoesLista($_pk,tag & $_tab,tipospadrao $_tipos) {
		if($this->_exibe_opcoes===true) {
			$_lnkexc = new tag($_tipos->getTipo("A"),Array(new atributo("HREF","javascript:void(0);"),
														   new atributo("ONCLICK","ObjProcAjax.run('{$_SERVER['PHP_SELF']}?ITENS=S&ACAO=EXC{$_pk}','CORPO');"))," Excluir ");
			$_tab->getLastSubTag()->addSubTag(new tag($_tipos->getTipo('TD'),
										  Array(new atributo("STYLE","border:1px solid #a0a0a0;")),$_lnkexc->toHTML()));
		}
	}

	/**
	 * Insere o botão de inclusão na lista de registros
	 *
	 * @param tag $_div
	 * @param tipospadrao $_tipos
	 */
	protected function getBotaoIncluir(tag & $_div,tipospadrao $_tipos) {
		if($this->_exibe_opcoes===true||$this->_exibe_botao_incluir===true) {
			$_div->addSubTag(new tag($_tipos->getTipo("BR")));
			$_div->addSubTag(new tag($_tipos->getTipo("P"),Array(new atributo("ALIGN","CENTER"))));
			$_div->getLastSubTag()->addSubTag(new tag($_tipos->getTipo('BUTTON'),
												Array(new atributo("ONCLICK","ObjProcAjax.run('{$_SERVER['PHP_SELF']}?ITENS=S&" . 
																			 "ACAO=INC&INVENTARIO_CODIGO={$_GET['INVENTARIO_CODIGO']}'," . 
																			 "'CORPO');")),
												" Incluir Novo Registro "));
		}
	}
	
	/**
	 * Se o Inventário estiver congelado ou consolidado
	 * não será possivel incluir ou excluir itens
	 */
	public function listar() {
		$_inv = new inventario($this->_conn);
		if($_inv->inventarioliberado($_GET['INVENTARIO_CODIGO'])===false) {
			$this->_exibe_opcoes = false;
			$this->_exibe_botao_incluir = false;
		}
		return parent::listar();
	}
	
	/**
	 * Executa o congelamento do inventário selecionado
	 * 1 - atualiza a tabela de inventarioproduto com o estoque e custo médio
	 * 2 - marca o inventário como congelado
	 *
	 * @param string $_inv
	 * @return mixed
	 */
	public function congelar($_inv) {
		$_strSQL = "SELECT PRODUTO_CODIGO,LOCAL_CODIGO,PRODUTO_ESTOQUE,PRODUTO_CUSTOMEDIO FROM " . 
					"ESTOQUELOCAL WHERE PRODUTO_CODIGO IN(SELECT PRODUTO_CODIGO FROM {$this->_nome_tabela} " . 
					"WHERE INVENTARIO_CODIGO='{$_inv}')";
		if($this->_conn->executaSQL($_strSQL)!==false&&$this->_conn->getNumRows()>0) {
			while(($_dados=$this->_conn->proximo())!==false) {
				$_produtos[$_dados['PRODUTO_CODIGO']][$_dados['LOCAL_CODIGO']] = Array($_dados["PRODUTO_ESTOQUE"],$_dados["PRODUTO_CUSTOMEDIO"]);
			}
			$this->getCampo("INVENTARIO_CODIGO")->setValor($_inv);
			foreach($_produtos as $_prd=>$_local) {
				$this->getCampo("PRODUTO_CODIGO")->setValor($_prd);
				foreach($_local as $_lcl=>$_info) {
					$this->getCampo("LOCAL_CODIGO")->setValor($_lcl);
					$this->getCampo("PRODUTO_ESTOQUE")->setValor(number_format($_info[0],3,",",""));
					$this->getCampo("PRODUTO_CUSTOMEDIO")->setValor(number_format($_info[1],2,",",""));
					$this->setUsuarioeData();
					if($this->alterar()===false) {
						return false;
					}
				}
			}
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Busca os produtos do inventário
	 * retornando os dados no formato JSON
	 * 
	 * @return string JSON 
	 */
	public function buscaprodutos() {
		$_strSQL = "SELECT DISTINCT IP.PRODUTO_CODIGO,P.PRODUTO_DESC FROM {$this->_nome_tabela} IP " . 
				   "LEFT JOIN INVENTARIO I ON IP.INVENTARIO_CODIGO=I.INVENTARIO_CODIGO " . 
				   "LEFT JOIN PRODUTO P ON IP.PRODUTO_CODIGO=P.PRODUTO_CODIGO " .
				   "WHERE NOT EXISTS (" . 
				   "	SELECT 1 FROM CONTAGEM C " . 
				   "	WHERE C.PRODUTO_CODIGO=IP.PRODUTO_CODIGO AND " . 
				   "	C.LOCAL_CODIGO=IP.LOCAL_CODIGO AND " . 
				   "	C.INVENTARIO_CODIGO=IP.INVENTARIO_CODIGO AND " . 
				   "	C.CONTAGEM_NUMERO=I.INVENTARIO_CONTAGEM) " . 
				   "AND IP.INVENTARIO_CODIGO='{$_POST['INVENTARIO_CODIGO']}'";
		$_arr = Array();
		if($this->_conn->executaSQL($_strSQL)!==false&&$this->_conn->getNumRows()>0) {
			while(($_dados=$this->_conn->proximo())!==false) {
				$_arr[] = array_map(utf8_encode,$_dados);
			}
		}
		echo json_encode($_arr);
	}
	
	/**
	 * Busca os Locais do produto selecionado do inventário
	 * retornando os dados no formato JSON
	 * 
	 * @return string JSON 
	 */
	public function buscaLocais() {
		$_strSQL = "SELECT DISTINCT IP.LOCAL_CODIGO,L.LOCAL_DESC FROM {$this->_nome_tabela} IP " . 
				   "LEFT JOIN INVENTARIO I ON IP.INVENTARIO_CODIGO=I.INVENTARIO_CODIGO " . 
				   "LEFT JOIN LOCALESTOQUE L ON IP.LOCAL_CODIGO=L.LOCAL_CODIGO " .
				   "WHERE NOT EXISTS (" . 
				   "	SELECT 1 FROM CONTAGEM C " . 
				   "	WHERE C.PRODUTO_CODIGO=IP.PRODUTO_CODIGO AND " . 
				   "	C.LOCAL_CODIGO=IP.LOCAL_CODIGO AND " . 
				   "	C.INVENTARIO_CODIGO=IP.INVENTARIO_CODIGO AND " . 
				   "	C.CONTAGEM_NUMERO=I.INVENTARIO_CONTAGEM) " . 
				   "AND IP.INVENTARIO_CODIGO='{$_POST['INVENTARIO_CODIGO']}' " . 
				   "AND IP.PRODUTO_CODIGO='{$_POST['PRODUTO_CODIGO']}'";
		$_arr = Array();
		if($this->_conn->executaSQL($_strSQL)!==false&&$this->_conn->getNumRows()>0) {
			while(($_dados=$this->_conn->proximo())!==false) {
				$_arr[] = array_map(utf8_encode,$_dados);
			}
		}
		echo json_encode($_arr);
	}
	
	/**
	 * Busca as contagens do estoque
	 *
	 * @param string $_inventario
	 * @param integer $_contagem
	 * @return array
	 */
	public function buscarContagens($_inventario,$_contagem) {
		$_strSQL = "SELECT I.PRODUTO_CODIGO,P.PRODUTO_DESC,I.LOCAL_CODIGO,L.LOCAL_DESC," . 
				   "I.PRODUTO_ESTOQUE,C.CONTAGEM_ESTOQUE";
		if($_contagem>1) {
			$_strSQL .= ",CC.CONTAGEM_ESTOQUE AS CONTAGEM_ANTERIOR";
		}
		$_strSQL .= " FROM {$this->_nome_tabela} I " . 
					"LEFT JOIN CONTAGEM C ON I.INVENTARIO_CODIGO=C.INVENTARIO_CODIGO AND " . 
					"I.PRODUTO_CODIGO=C.PRODUTO_CODIGO AND I.LOCAL_CODIGO=C.LOCAL_CODIGO AND " .
					"C.CONTAGEM_NUMERO={$_contagem} " . 
					"LEFT JOIN PRODUTO P ON I.PRODUTO_CODIGO=P.PRODUTO_CODIGO " . 
					"LEFT JOIN LOCALESTOQUE L ON I.LOCAL_CODIGO=L.LOCAL_CODIGO ";
		if($_contagem>1) {
			$_strSQL .=	"LEFT JOIN CONTAGEM CC ON I.INVENTARIO_CODIGO=CC.INVENTARIO_CODIGO AND " . 
						"I.PRODUTO_CODIGO=CC.PRODUTO_CODIGO AND I.LOCAL_CODIGO=CC.LOCAL_CODIGO AND " . 
						"CC.CONTAGEM_NUMERO=" . ($_contagem-1) . " ";
		}
		$_strSQL .= "WHERE I.INVENTARIO_CODIGO='{$_inventario}' AND I.INVENTARIO_ESTOQUE IS NULL";
		$_res = Array();
		if($this->_conn->executaSQL($_strSQL)!==false&&$this->_conn->getNumRows()>0) {
			while($_dados=$this->_conn->proximo()) {
				$_res[] = $_dados;
			}
		}
		return $_res;
	}
	
	/**
	 * Marca os itens inventariado com divergencia
	 *
	 * @param string $_itens
	 * @return boolean
	 */
	public function marcaitensnok($_itens) {
		return $this->_conn->executaSQL("UPDATE {$this->_nome_tabela} SET INVENTARIO_ESTOQUE = NULL WHERE {$_itens}");
	}
	
	/**
	 * Marca os itens sem divergencia, ajustando o valor do estoque inventariado
	 *
	 * @param array $_itens
	 * @return boolean
	 */
	public function marcaitensok($_itens) {
		foreach($_itens as $_item) {
			if($this->_conn->executaSQL("UPDATE {$this->_nome_tabela} {$_item}")===false) {
				return false;
			}
		}
		return true;
	}
	

	/**
	 * Ajusta os valores padrões para o movimento
	 *
	 * @param historicomovimento $_his
	 */
	protected function ajustaHistorico(historicomovimento &$_his) {
		$_his->getCampo("PRODUTO_CODIGO")->setValor($this->getCampo("PRODUTO_CODIGO")->getValor());
		$_his->getCampo("LOCAL_CODIGO")->setValor($this->getCampo("LOCAL_CODIGO")->getValor());
		$_his->getCampo("HISTORICO_DOCUMENTO")->setValor('INV_' . $this->getCampo("INVENTARIO_CODIGO")->getValor());
		$_his->getCampo("HISTORICO_DATA")->setValor(date("d-m-Y"));		
		$_his->getCampo("HISTORICO_VALOR_UNIT")->setValor($this->getCampo("PRODUTO_CUSTOMEDIO")->toHTML());
		$_his->getCampo("HISTORICO_HISTORICO")->setValor("Ajuste de Inventário");
	}
	
	/**
	 * Gera os movimentos de ajuste de estoque para
	 * o inventário informado
	 *
	 * @param string $_iv
	 * @param string $_tme
	 * @param string $_tms
	 * @return boolean
	 */
	public function consolidar($_iv,$_tme,$_tms) {
		$_ent = new entradas($this->_conn);
		$_sai = new saidas($this->_conn);
		if($this->_conn->executaSQL("SELECT * FROM {$this->_nome_tabela} WHERE INVENTARIO_CODIGO='{$_iv}'")!==false&&$this->_conn->getNumRows()>0) {
			while($_dados=$this->_conn->proximo()) {
				$_itens[] = $_dados;
			}
			foreach($_itens as $_campos) {
				foreach($_campos as $_nome=>$_vlr) {
					$this->getCampo($_nome)->setValor($_vlr);
				}
				$_div = $this->getCampo("PRODUTO_ESTOQUE")->getValor()-$this->getCampo("INVENTARIO_ESTOQUE")->getValor();
				if($_div<0) {
					// Entrada no estoque
					$this->ajustaHistorico($_ent);
					$_div *=-1;
					$_ent->getCampo("HISTORICO_VALOR_TOTAL")->setValor($this->getCampo("PRODUTO_CUSTOMEDIO")->getValor()*$_div);
					$_ent->getCampo("TIPOMOV_CODIGO")->setValor($_tme);
					$_ent->getCampo("HISTORICO_QUANTIDADE")->setValor($_div);		
					if($_ent->incluir()===false) {
						return false; //temos um erro aqui
					}
				} elseif($_div>0) {
					// Saída
					$this->ajustaHistorico($_sai);
					$_sai->getCampo("CUSTO_SAIDA")->setValor($this->getCampo("PRODUTO_CUSTOMEDIO")->toHTML());
					$_sai->getCampo("TIPOMOV_CODIGO")->setValor($_tms);
					$_sai->getCampo("HISTORICO_QUANTIDADE")->setValor($_div);		
					if($_sai->incluir()===false) {
						return false;
					}
				}
			}
		} else {
			return false;
		}
		return true;
	}
}
?>