<?php
/**
 * Classe inventario
 */
class inventario extends base {
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->_nome_tabela = 'inventario';
		$this->_class_path = 'estoque';
		$this->addCampo(new string("INVENTARIO_CODIGO","Código do Inventário",10,null,null,true,false,true,1,null,null,true,$_conn));
		$this->addCampo(new string("INVENTARIO_DESC","Descrição",30,null,null,true,true,true,5,null,null,false,$_conn));
		$this->addCampo(new data("INVENTARIO_DATA_PREVISTA","Data Prevista",10,null,null,true,true,true,'NOW',null,null,false,$_conn));
		$this->addCampo(new data("INVENTARIO_DATA_REAL","Data Realizado",10,null,null,false,false,true,'NOW',null,null,false,$_conn));
		$this->addCampo(new string("INVENTARIO_CONGELADO","Congelado",1,null,null,false,false,true,null,null,null,false,$_conn));
		$this->addCampo(new inteiro("INVENTARIO_CONTAGEM","Contagem atual",1,null,null,false,false,false,1,null,null,false));
		$this->addCampo(new string("INVENTARIO_CONSOLIDADO","Fechado",1,null,null,false,false,true,1,null,null,false,$_conn));
		$this->addCampo(new string("LOCAL_CODIGO","Local",10,null,null,true,false,true,1,null,null,false,$_conn));
		$this->addCampo(new string("USUARIO_LOGIN","Usuário",20,null,null,false,false,false,null,null,null,false,$_conn));
		$this->addCampo(new datahora("DATA_ULTIMA_ALTERACAO","Data",14,null,null,false,false,false,null,null,null,false,$_conn));
		$this->getCampo("INVENTARIO_CODIGO")->setComportamento_form('proximo');
		$this->getCampo("LOCAL_CODIGO")->setComportamento_form('select');
	}
	
	/**
	 * Retorna o comando SQL necessário para
	 * a busca do próximo código
	 *
	 * @return string
	 */
	public function montaSQLProximoCodigo() {
		return "SELECT MAX(INVENTARIO_CODIGO) AS CODIGO FROM {$this->_nome_tabela}";
	}
	
	/**
	 * Ajustar os campos Usuário e data da
	 * última alteração antes de efetivar a transação
	 *
	 * @return mixed
	 */
	public function incluir() {
		$this->setUsuarioeData();
		return parent::incluir();
	}
	
	/**
	 * Ajustar os campos Usuário e data da
	 * última alteração antes de efetivar a transação
	 *
	 * @return mixed
	 */
	public function Alterar() {
		$this->setUsuarioeData();
		return parent::alterar();
	}
	
	/**
	 * Executa a operação de congelamento de inventário
	 *
	 * @param string $_inv
	 * @return mixed
	 */
	public function congelar($_inv) {
		$this->getCampo("INVENTARIO_DESC")->setAlterar(false);
		$this->getCampo("INVENTARIO_DATA_PREVISTA")->setAlterar(false);
		$this->getCampo("INVENTARIO_DATA_REAL")->setAlterar(false);
		$this->getCampo("INVENTARIO_CONGELADO")->setAlterar(true);
		$this->getCampo("INVENTARIO_CONGELADO")->setValor('S');
		$this->getCampo("INVENTARIO_CODIGO")->setValor($_inv);
		return $this->alterar();
	}
	
	public function getFormulario($_funcao='INC') {
		$_local = new localestoque($this->_conn);
		$_local->Buscar();
		if($_local->getConn()->getNumrows()<1) {
			die(utf8_encode("<span style='color:red;font-size:20px;text-align:center;'>É necessário ter pelo menos 1 Local cadastrado</span>"));
		}
		$_lc[] = Array("valor"=>"TODOS","label"=>"TODOS");
		while($_local->proximo()!==false) {
			$_lc[] = Array("valor"=>$_local->getCampo('LOCAL_CODIGO')->getValor(),
							 "label"=>$_local->getCampo('LOCAL_DESC')->getValor());
		}
		$this->getCampo("LOCAL_CODIGO")->setValor_fixo($_lc);
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
		$_lnkitens = new tag($_tipos->getTipo("A"),Array(new atributo("HREF","javascript:void(0);"),
													   new atributo("ONCLICK","ObjProcAjax.run('{$_SERVER['PHP_SELF']}?ITENS=S{$_pk}','CORPO');"))," Itens ");
		$_lnkalt = new tag($_tipos->getTipo("A"),Array(new atributo("HREF","javascript:void(0);"),
													   new atributo("ONCLICK","ObjProcAjax.run('{$_SERVER['PHP_SELF']}?ACAO=ALT{$_pk}','CORPO');"))," Alterar ");
		$_lnkexc = new tag($_tipos->getTipo("A"),Array(new atributo("HREF","javascript:void(0);"),
													   new atributo("ONCLICK","ObjProcAjax.run('{$_SERVER['PHP_SELF']}?ACAO=EXC{$_pk}','CORPO');"))," Excluir ");
		$_tab->getLastSubTag()->addSubTag(new tag($_tipos->getTipo('TD'),
									  Array(new atributo("STYLE","border:1px solid #a0a0a0;")),$_lnkitens->toHTML() . $_lnkalt->toHTML() . $_lnkexc->toHTML()));
	}
	
	/**
	 * Retorna se o inventário está liberado 
	 * para manutenção ou não
	 * para ser liberado INVENTARIO_CONGELADO e INVENTARIO_CONSOLIDADO
	 * Devem estar com valor 'N'
	 *
	 * @param string $_inv
	 * @return boolean
	 */
	public function inventarioliberado($_inv) {
		$_strSQL = "SELECT INVENTARIO_CONGELADO,INVENTARIO_CONSOLIDADO FROM {$this->_nome_tabela} " . 
				   "WHERE INVENTARIO_CODIGO='{$_inv}'";
		$_liberado = true;
		if($this->_conn->executaSQL($_strSQL)!==false&&$this->_conn->getNumRows()>0) {
			$_dados = $this->_conn->proximo();
			if($_dados['INVENTARIO_CONGELADO']=='S'||$_dados['INVENTARIO_CONSOLIDADO']=='S') {
				$_liberado = false;
			}
		}
		return $_liberado;
	}
	
	/**
	 * Retorna a lista de inventários liberados
	 *
	 * @return array
	 */
	public function buscaLiberados() {
		if($this->_conn->executaSQL($this->montaSELECT("INVENTARIO_CODIGO,INVENTARIO_DESC",
														"(INVENTARIO_CONGELADO='N' AND INVENTARIO_CONSOLIDADO='N')",
														"INVENTARIO_CODIGO DESC"))===false) {
			return Array();
		} else {
			$_inv = Array();
			while(($_dados=$this->_conn->proximo())!==false) {
				$_inv[] = Array("valor"=>$_dados['INVENTARIO_CODIGO'],
								"label"=>$_dados['INVENTARIO_DESC']);
			}
			return $_inv;
		}
	}
	
	/**
	 * Retorna a Lista de inventários disponiveis
	 * Ou seja Congelado=S Consolidado=N
	 *
	 * @return array
	 */
	public function buscaLiberadosFicha() {
		if($this->_conn->executaSQL($this->montaSELECT("INVENTARIO_CODIGO,INVENTARIO_DESC",
														"(INVENTARIO_CONGELADO='S' AND INVENTARIO_CONSOLIDADO='N')",
														"INVENTARIO_CODIGO DESC"))===false) {
			return Array();
		} else {
			$_inv = Array();
			while(($_dados=$this->_conn->proximo())!==false) {
				$_inv[] = Array("valor"=>$_dados['INVENTARIO_CODIGO'],
								"label"=>$_dados['INVENTARIO_DESC']);
			}
			return $_inv;
		}
	}
	
	/**
	 * Busca o número da contagem atual do inventário informado
	 *
	 */
	public function buscaContagem() {
		$this->Buscar(Array("INVENTARIO_CODIGO"=>$_POST['INVENTARIO_CODIGO']));
		$this->proximo();
		echo $this->getCampo("INVENTARIO_CONTAGEM")->toHTML();
	}
	
	/**
	 * Realiza a Análise do inventário
	 * O resultado é uma lista dos itens inventariados
	 * e a sua situação que pode ser: "OK" ou "Necessita recontagem"
	 * No final da lista exibe as opções
	 * - Confirmar o inventário (com divergencias ou não)
	 * - Gerar recontagem
	 *
	 * Buscar Itens + Contagens de cada produto+local (contagem atual)
	 * Buscar a contagem N-1 (se n>1)
	 * Regra basica Contagem N = Contagem N-1
	 * Se N=1 => Contagem 1 = Estoque atual
	 * Caso contrário gera uma divergencia
	 * 
	 */
	public function analisar() {
		$this->Buscar(Array("INVENTARIO_CODIGO"=>$_POST['INVENTARIO_CODIGO']));
		$this->proximo();
		if($this->getCampo("INVENTARIO_CONSOLIDADO")->getValor()=='S') {
			$_div = new tag(new tipotag("DIV"),Array(new atributo("STYLE","padding-bottom:5px;")),"Inventário já está consolidado.");
			echo utf8_encode($_div->toHTML());
			return;
		}
		$_ip = new inventarioproduto($this->_conn);
		$_itens = $_ip->buscarContagens($_POST['INVENTARIO_CODIGO'],$this->getCampo("INVENTARIO_CONTAGEM")->getValor());
		// Montar a lista e decidir o que fazer...
		$_divergencias = 0;
		$_trt = new tipotag("TR");
		$_tdt = new tipotag("TD");
		$_tab = new tag(new tipotag('TABLE'),Array(new atributo("BORDER",0),
														new atributo("CELLPADDING",1),
														new atributo("STYLE","border:1px solid #a0a0a0;border-collapse:collapse;"),
														new atributo("WIDTH","100%"),
														new atributo("ID","TAB_CONTAGEM")));
		$_bd  = new tag(new tipotag("TBODY"));
		$_tr  = new tag($_trt);
		$_tr->addSubTag(new tag(new tipotag('TH'),Array(new atributo("STYLE","border:1px solid #a0a0a0;background-color:#f0f0f0;")),"Produto"));
		$_tr->addSubTag(new tag(new tipotag('TH'),Array(new atributo("STYLE","border:1px solid #a0a0a0;background-color:#f0f0f0;")),"Local"));
		$_tr->addSubTag(new tag(new tipotag('TH'),Array(new atributo("STYLE","border:1px solid #a0a0a0;background-color:#f0f0f0;")),"Estoque Congelado"));
		if($this->getCampo("INVENTARIO_CONTAGEM")->getValor()>1) {
			$_tr->addSubTag(new tag(new tipotag('TH'),Array(new atributo("STYLE","border:1px solid #a0a0a0;background-color:#f0f0f0;")),
																				"Contagem " . ($this->getCampo("INVENTARIO_CONTAGEM")->getValor()-1)));		
		}
		$_tr->addSubTag(new tag(new tipotag('TH'),Array(new atributo("STYLE","border:1px solid #a0a0a0;background-color:#f0f0f0;")),
																				"Contagem {$this->getCampo("INVENTARIO_CONTAGEM")->getValor()}"));		
		$_tr->addSubTag(new tag(new tipotag('TH'),Array(new atributo("STYLE","border:1px solid #a0a0a0;background-color:#f0f0f0;")),"Situação"));
		$_bd->addSubTag($_tr);
		$_var = "var contagem=[];";
		foreach($_itens as $_item) {
			$_tr = new tag($_trt);
			$_tr->addSubTag(new tag($_tdt,null,$_item['PRODUTO_CODIGO'] . "-" . $_item["PRODUTO_DESC"]));
			$_tr->addSubTag(new tag($_tdt,null,$_item['LOCAL_CODIGO'] . "-" . $_item["LOCAL_DESC"]));
			$_tr->addSubTag(new tag($_tdt,Array(new atributo("STYLE","padding-right:5px;text-align:RIGHT")),number_format($_item['PRODUTO_ESTOQUE'],3,",",".")));
			if($this->getCampo("INVENTARIO_CONTAGEM")->getValor()>1) {
				$_tr->addSubTag(new tag($_tdt,Array(new atributo("STYLE","padding-right:5px;text-align:RIGHT")),
										($_item['CONTAGEM_ANTERIOR']===null ? "-" : number_format($_item['CONTAGEM_ANTERIOR'],3,",","."))));
			}
			$_tr->addSubTag(new tag($_tdt,Array(new atributo("STYLE","padding-right:5px;text-align:RIGHT")),
										($_item['CONTAGEM_ESTOQUE']===null ? "-" : number_format($_item['CONTAGEM_ESTOQUE'],3,",","."))));
			$_parametro_1 = $_item['CONTAGEM_ESTOQUE'];
			$_parametro_2 = ($this->getCampo("INVENTARIO_CONTAGEM")->getValor()>1 ? $_item['CONTAGEM_ANTERIOR'] : $_item['PRODUTO_ESTOQUE']);
			$_var .= "contagem[contagem.length]=['{$_item['PRODUTO_CODIGO']}','{$_item['LOCAL_CODIGO']}'," . number_format($_item['CONTAGEM_ESTOQUE'],3,".","") . ",";
			if($_parametro_1===null)  {
				++$_divergencias;
				$_tr->addSubTag(new tag($_tdt,Array(new atributo("STYLE","color:red")),"Não contado"));
				$_var .= "'nok'";
			} elseif($_parametro_1!=$_parametro_2) {
				++$_divergencias;
				$_tr->addSubTag(new tag($_tdt,Array(new atributo("STYLE","color:red")),"Quantidades Divergentes"));
				$_var .= "'nok'";
			} else {
				$_tr->addSubTag(new tag($_tdt,Array(new atributo("STYLE","color:blue")),"OK"));
				$_var .= "'ok'";
			}
			$_var .= "];";
			$_bd->addSubTag($_tr);
		}
		$_tab->addSubTag($_bd);
		$_divi = new tag(new tipotag("DIV"),Array(new atributo("STYLE","padding-bottom:5px;")),
								"Análise do Inventário {$_POST['INVENTARIO_CODIGO']}-{$this->getCampo("INVENTARIO_DESC")->toHTML()} , " . 
						 		"Contagem {$this->getCampo("INVENTARIO_CONTAGEM")->toHTML()}");
		$_divd = new tag(new tipotag("DIV"),Array(new atributo("STYLE","padding-top:5px;padding-bottom:10px;")),
								"{$_divergencias} divergencia(s) encontrada(s)");
		$_sc = new tag(new tipotag("SCRIPT"),null,$_var);
		echo utf8_encode($_divi->toHTML() . $_tab->toHTML() . $_divd->toHTML() . $_sc->toHTML());
		// Opcões
		$_form = new formulario("OPCOES_{$this->_nome_tabela}","#");
		$_form->deleteAtributo(4);
		$_form->addAtributo(new atributo("ONSUBMIT","return false;"));
		$_tab  = new tag(new tipotag("TABLE"),
						 Array(new atributo("BORDER",0),
						 	new atributo("CELLPADDING",2),
						 	new atributo("CELLSPACING",0),
						 	new atributo("STYLE","border:1px solid Navy;padding:15px;width:100%;border-collapse:collapse;")));
		$_tr = new tipotag("TR");
		$_td = new tipotag("TD");
		// Recontagem??
		$_tab->addSubTag(new tag($_tr));
		$_tab->getLastSubTag()->addSubTag(new tag($_td,Array(new atributo("COLSPAN",2),
														new atributo("STYLE","color:white;background-color:Navy;border: 1px solid Navy;vertical-align:top;")),
													   "Opções para este Inventário"));
		$_tab->addSubTag(new tag($_tr));
		if($_divergencias>0) {
			$_tab->getLastSubTag()->addSubTag(new tag($_td,Array(new atributo("ID","BTNOK"),new atributo("STYLE","padding:20px;border: 1px solid Navy;vertical-align:top;"))));
			$_ev = new Eventos();
			$_ev->setOnclick("objAnalise.recontagem('{$_POST['INVENTARIO_CODIGO']}')");
			$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new formInputSubmit("OK"," Gerar Recontagem Número " . ($this->getCampo("INVENTARIO_CONTAGEM")->getValor()+1),null,$_ev));
			$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("BR",false)));
			$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("BR",false)));
			$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("SPAN"),
											Array(new atributo("STYLE","color:blue")),
											" Esta opção confirma a contagem dos itens<br> considerados corretos(marcados como OK)<br>" . 
											" e gera uma nova contagem para os itens divergentes.<br>" . 
											" Os Ajustes de estoque não são gerados."));
		}
		$_tab->getLastSubTag()->addSubTag(new tag($_td,Array(new atributo("ID","BTNOK"),new atributo("STYLE","padding:20px;border: 1px solid Navy;vertical-align:top;"))));
		$_ev = new Eventos();
		$_ev->setOnclick("objAnalise.consolidar('{$_POST['INVENTARIO_CODIGO']}','{$_divergencias}')");
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new formInputSubmit("OK"," Confirmar o Inventário ",null,$_ev));
		$_tm = new tipomovimento($this->_conn);
		$_ent = array_merge(Array(Array("valor"=>"-","label"=>"Selecione o Tipo de Movimento")),$_tm->retornaLista('E'));
		$_sai = array_merge(Array(Array("valor"=>"-","label"=>"Selecione o Tipo de Movimento")),$_tm->retornaLista('S'));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("BR",false)));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("DIV"),
																Array(new atributo("STYLE","padding-top:5px;color:Navy;font-size:12px;")),
																"Tipo Movimento Entrada: "));
		$_tab->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new formSelect("TIPO_MOV_E",false,$_ent));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("DIV"),
																Array(new atributo("STYLE","padding-top:5px;color:Navy;font-size:12px;")),
																"Tipo Movimento Saída: "));
		$_tab->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new formSelect("TIPO_MOV_S",false,$_sai));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("BR",false)));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("SPAN"),
											Array(new atributo("STYLE","color:" . ($_divergencias==0 ? "blue" : "red"))),
											($_divergencias==0 
												?	" Confirma o Inventário Atual gerando os ajustes de estoque<br>" . 
													" Necessários, para isto deve-se escolher os tipos de movimentos<br>" . 
													" para ajustes de entrada e de saída."
												:	" Confirma o Inventário no modo forçado, ignorando<br>" . 
													" as divergencias encontradas. O sistema considera a<br>" . 
													" última contagem como base para o ajuste de estoque.<br>" . 
													" Produtos não contados serão considerados com saldo zero.<br>" . 
													" *** Esta não é a opção mais indicada ***"
											)));
		
		$_form->addSubTag($_tab);
		echo utf8_encode($_form->toHTML());
	}
	
	/**
	 * Marcar o inventário para recontagem
	 * os itens com situação OK 
	 * são retirados da recontagem
	 *
	 */
	public function recontar() {
		$_itens = json_decode($_POST['ITENS']);
		$this->_conn->startTransaction();
		$_nok = Array();
		$_ok  = Array();
		foreach($_itens as $_item) {
			if($_item[3]=='nok') {
				$_nok[] = "(INVENTARIO_CODIGO='{$_POST['INVENTARIO_CODIGO']}' AND PRODUTO_CODIGO='{$_item[0]}' AND LOCAL_CODIGO='{$_item[1]}')";
			} else {
				$_ok[] = "SET INVENTARIO_ESTOQUE={$_item[2]} WHERE " . 
						 "(INVENTARIO_CODIGO='{$_POST['INVENTARIO_CODIGO']}' AND PRODUTO_CODIGO='{$_item[0]}' AND LOCAL_CODIGO='{$_item[1]}')";
			}
		}
		$_ip = new inventarioproduto($this->_conn);
		if($_ip->marcaitensnok(implode(" OR ",$_nok))===false) {
			// erro
			$this->_conn->ROLLBACK();
			$_div = new tag(new tipotag("DIV"),Array(new atributo("STYLE","COLOR:red;")),"Erro ao marcar produtos não OK!");
			echo $_div->toHTML();
		} elseif($_ip->marcaitensok($_ok)===false) {
			// erro tb
			$this->_conn->ROLLBACK();
			$_div = new tag(new tipotag("DIV"),Array(new atributo("STYLE","COLOR:red;")),"Erro ao marcar produtos OK!");
		} else {
			$_strSQL = 	"UPDATE {$this->_nome_tabela} SET INVENTARIO_CONTAGEM=INVENTARIO_CONTAGEM+1 " . 
						"WHERE INVENTARIO_CODIGO='{$_POST['INVENTARIO_CODIGO']}'";
			if($this->_conn->executaSQL($_strSQL)===false) {
				$this->_conn->ROLLBACK();
				$_div = new tag(new tipotag("DIV"),Array(new atributo("STYLE","COLOR:red;")),"Erro ao marcar o Inventário!");
			} else {
				$this->_conn->commit();
				$_div = new tag(new tipotag("DIV"),Array(new atributo("STYLE","COLOR:BLUE;")),"Recontagem do Inventário {$_POST['INVENTARIO_CODIGO']} Gerada com sucesso!");
			}
		}
		echo utf8_encode($_div->toHTML());
	}
	
	/**
	 * Consolida o inventário
	 * Executando o lançamento no estoque 
	 * para ajustes
	 *
	 */
	public function consolidar() {
		$_itens = json_decode($_POST['ITENS']);
		$_ok = Array();
		foreach($_itens as $_item) {
			$_ok[] = "SET INVENTARIO_ESTOQUE=" . number_format($_item[2],3,".","") . " WHERE " . 
						 "(INVENTARIO_CODIGO='{$_POST['INVENTARIO_CODIGO']}' AND PRODUTO_CODIGO='{$_item[0]}' AND LOCAL_CODIGO='{$_item[1]}')";
		}
		$this->_conn->startTransaction();
		$_ip = new inventarioproduto($this->_conn);
		if($_ip->marcaitensok($_ok)===false) {
			$this->_conn->ROLLBACK();
			$_div = new tag(new tipotag("DIV"),Array(new atributo("STYLE","COLOR:red;")),"Erro ao processar o Inventário (marcar itens) - {$this->_conn->getUltimoErro()}!");
		} else {
			// Agora geramos os movimentos de ajuste
			if($_ip->consolidar($_POST['INVENTARIO_CODIGO'],$_POST['TIPO_MOV_E'],$_POST['TIPO_MOV_S'])===false) {
				$this->_conn->ROLLBACK();
				$_div = new tag(new tipotag("DIV"),Array(new atributo("STYLE","COLOR:red;")),"Erro ao Consolidar o Inventário (itens) - {$this->_conn->getUltimoErro()}!");
			} else {
				$this->getCampo("INVENTARIO_DATA_REAL")->setValor(date("d-m-Y"));
				if($this->_conn->executaSQL("UPDATE {$this->_nome_tabela} " .
											"SET INVENTARIO_CONSOLIDADO='S'," . 
											"INVENTARIO_DATA_REAL={$this->getCampo("INVENTARIO_DATA_REAL")->toBD()} " . 
											"WHERE INVENTARIO_CODIGO='{$_POST['INVENTARIO_CODIGO']}'")===false) {
					$this->_conn->ROLLBACK();
					$_div = new tag(new tipotag("DIV"),Array(new atributo("STYLE","COLOR:red;")),"Erro ao Consolidar o Inventário - {$this->_conn->getUltimoErro()} !");
				} else {
					$this->_conn->commit();
					$_div = new tag(new tipotag("DIV"),Array(new atributo("STYLE","COLOR:blue;")),"Inventário Consolidado!");
				}
			}
		}
		echo utf8_encode($_div->toHTML());
	}
}
?>