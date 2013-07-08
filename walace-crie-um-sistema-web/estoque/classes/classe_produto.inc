<?php
/**
 * Classe produto
 */
class produto extends base {
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->_nome_tabela = 'produto';
		$this->_class_path = 'estoque';
		$this->addCampo(new string("PRODUTO_CODIGO","Código do Produto",20,null,null,true,false,true,1,null,null,true,$_conn));
		$this->addCampo(new string("PRODUTO_DESC","Descrição",60,null,null,true,true,true,5,null,null,false,$_conn));
		$this->addCampo(new string("DEPTO_CODIGO","Código do Departamento",10,null,null,true,true,true,1,null,null,false,$_conn));
		$this->addCampo(new string("GRUPO_CODIGO","Código do Grupo",10,null,null,true,true,true,1,null,null,false,$_conn));
		$this->addCampo(new string("UNIDADE_CODIGO","Código da Unidade",4,null,null,true,true,false,1,null,null,false,$_conn));
		$this->addCampo(new float("PRODUTO_PESO","Peso do Produto",10,null,null,true,true,false,0.001,null,null,false,5));
		$this->addCampo(new float("PRODUTO_ESTOQUE","Estoque Atual",12,null,null,false,false,true,0.001,null,null,false));
		$this->addCampo(new dinheiro("PRODUTO_PRECO","Preço Atual",12,null,null,true,true,true,0,null,null,false));
		$this->addCampo(new dinheiro("PRODUTO_CUSTOATUAL","Custo Atual",12,null,null,true,true,true,0,null,null,false));
		$this->addCampo(new dinheiro("PRODUTO_CUSTOMEDIO","Custo médio",12,null,null,false,false,false,0,null,null,false));
		$this->addCampo(new float("PRODUTO_EST_MINIMO","Estoque Minimo do Produto",10,null,null,true,true,false,0,null,null,false));
		$this->addCampo(new float("PRODUTO_EST_MAXIMO","Estoque Máximo do Produto",10,null,null,true,true,false,'[PRODUTO_EST_MINIMO]',null,null,false));
		$this->addCampo(new float("PRODUTO_AC_ENT_QDE","Acumulado de Entradas (Quantidade)",18,null,null,false,false,false,1,null,null,false));
		$this->addCampo(new float("PRODUTO_AC_ENT_VLR","Acumulado de Entradas (Valor)",18,null,null,false,false,false,null,null,null,false));
		$this->addCampo(new float("PRODUTO_AC_SAIDAS","Acumulado de Saídas (Quantidade)",18,null,null,false,false,false,null,null,null,false));
		$this->addCampo(new string("USUARIO_LOGIN","Usuário",20,null,null,false,false,false,null,null,null,false,$_conn));
		$this->addCampo(new datahora("DATA_ULTIMA_ALTERACAO","Data",14,null,null,false,false,false,null,null,null,false,$_conn));
		$this->getCampo("PRODUTO_CODIGO")->setComportamento_form('proximo');
	}
	
	public function montaSQLAjax() {
		return $this->montaSELECT("PRODUTO_CODIGO AS CODIGO,PRODUTO_DESC AS DESCRICAO",
								  "(UPPER(PRODUTO_CODIGO) LIKE '%" . strtoupper($_POST['valor']) . "%' OR " . 
								  "UPPER(PRODUTO_DESC) LIKE '%" . strtoupper($_POST['valor'])  . "%')");
	}
	
	
	/**
	 * Retorna o comando SQL necessário para
	 * a busca do próximo código
	 *
	 * @return string
	 */
	public function montaSQLProximoCodigo() {
		return "SELECT MAX(PRODUTO_CODIGO) AS CODIGO FROM {$this->_nome_tabela}";
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
	
	public function getFormulario($_funcao='INC') {
		$_depto = new departamento($this->_conn);
		$_depto->Buscar();
		if($_funcao=='INC') {
			if($_depto->getConn()->getNumrows()<1) {
				die(utf8_encode("<span style='color:red;font-size:20px;text-align:center;'>É necessário ter pelo menos 1 departamento cadastrado</span>"));
			}
		}
		$this->getCampo("DEPTO_CODIGO")->setComportamento_form('select');
		while($_depto->proximo()!==false) {
			$_ldep[] = Array("valor"=>$_depto->getCampo('DEPTO_CODIGO')->getValor(),
							 "label"=>$_depto->getCampo('DEPTO_DESC')->getValor());
		}
		$this->getCampo("DEPTO_CODIGO")->setValor_fixo($_ldep);
		$_grupo = new grupo($this->_conn);
		$_grupo->Buscar();
		if($_funcao=='INC') {
			if($_grupo->getConn()->getNumrows()<1) {
				die(utf8_encode("<span style='color:red;font-size:20px;text-align:center;'>É necessário ter pelo menos 1 grupo cadastrado</span>"));
			}
		}
		$this->getCampo("GRUPO_CODIGO")->setComportamento_form('select');
		while($_grupo->proximo()!==false) {
			$_lgrp[] = Array("valor"=>$_grupo->getCampo('GRUPO_CODIGO')->getValor(),
							 "label"=>$_grupo->getCampo('GRUPO_DESC')->getValor());
		}
		$this->getCampo("GRUPO_CODIGO")->setValor_fixo($_lgrp);
		$_un = new unidade($this->_conn);
		$_un->Buscar();
		if($_funcao=='INC') {
			if($_un->getConn()->getNumrows()<1) {
				die(utf8_encode("<span style='color:red;font-size:20px;text-align:center;'>É necessário ter pelo menos 1 unidade cadastrada</span>"));
			}
		}
		$this->getCampo("UNIDADE_CODIGO")->setComportamento_form('select');
		while($_un->proximo()!==false) {
			$_lun[] = Array("valor"=>$_un->getCampo('UNIDADE_CODIGO')->getValor(),
							 "label"=>$_un->getCampo('UNIDADE_DESC')->getValor());
		}
		$this->getCampo("UNIDADE_CODIGO")->setValor_fixo($_lun);
		$this->_num_colunas_form = 2;
		return parent::getFormulario($_funcao);
	}
	
	/**
	 * Calculo do Custo médio
	 * Fórmula
	 * 	CM = (Acumulado_entradas_valor)/(Acumulado_entradas_qde)
	 *
	 */
	public function calculaCustoMedio() {
		$this->getCampo("PRODUTO_CUSTOMEDIO")->setValor(($this->getCampo("PRODUTO_AC_ENT_QDE")->getValor())<>0 
							? ($this->getCampo("PRODUTO_AC_ENT_VLR")->getValor()) / ($this->getCampo("PRODUTO_AC_ENT_QDE")->getValor())
							: 0
						);
	}
	
	/**
	 * Gera os acumulados de Entrada
	 *
	 * @param float $_qde
	 * @param float $_vlr
	 */
	public function acumulaEntradas($_qde,$_vlr) {
		$this->getCampo("PRODUTO_AC_ENT_QDE")->setValor($this->getCampo("PRODUTO_AC_ENT_QDE")->getValor()+$_qde);
		$this->getCampo("PRODUTO_AC_ENT_VLR")->setValor($this->getCampo("PRODUTO_AC_ENT_VLR")->getValor()+$_vlr);
	}
	
	/**
	 * Gera o acumulado de Saidas
	 *
	 * @param float $_qde
	 */
	public function acumulaSaidas($_qde) {
		$this->getCampo("PRODUTO_AC_SAIDAS")->setValor($this->getCampo("PRODUTO_AC_SAIDAS")->getValor()+$_qde);
	}
	
	/**
	 * Acerta o saldo atual do produto
	 *
	 * @param float $_qde
	 */
	protected function acertaSaldoAtual($_qde) {
		$this->getCampo("PRODUTO_ESTOQUE")->setValor($this->getCampo("PRODUTO_ESTOQUE")->getValor() + $_qde);
	}
	
	/**
	 * Atualiza o Custo Atual do produto
	 *
	 * @param float $_vlr
	 */
	protected function acertaCustoAtual($_vlr) {
		$this->getCampo("PRODUTO_CUSTOATUAL")->setValor($_vlr);
	}
	
	/**
	 * Realiza os acertos necessários no produto
	 *
	 * @param float $_qde
	 * @param float $_vlr
	 * @param tipomovimento $_tipo
	 */
	public function acertaEstoque($_qde,$_vlr,tipomovimento $_tipo) {
		$this->acertaSaldoAtual($_tipo->getCampo("TIPOMOV_TIPO")->getValor()=='E' ? $_qde : $_qde*-1);
		if($_tipo->getCampo("TIPOMOV_ESTORNO")->getValor()=='S') {
			$_qde *= -1;
			$_vlr *= -1;
		}
		if($_tipo->getCampo("TIPOMOV_CUSTOMEDIO")->getValor()=='S') {
			$this->acumulaEntradas($_qde,$_vlr);
			$this->calculaCustoMedio();
		} elseif($_tipo->getCampo("TIPOMOV_TIPO")->getValor()=='S') {
			$this->acumulaSaidas($_qde);
		}
		if($_tipo->getCampo("TIPOMOV_CUSTOATUAL")->getValor()=='S'&&$_vlr>0) {
			$this->acertaCustoAtual($_vlr/$_qde);
		}
		$_strSQL = "UPDATE {$this->_nome_tabela} SET " . 
				   " PRODUTO_ESTOQUE=" . $this->getCampo("PRODUTO_ESTOQUE")->getValor() . 
				   ",PRODUTO_CUSTOMEDIO=" . $this->getCampo("PRODUTO_CUSTOMEDIO")->getValor() . 
				   ",PRODUTO_CUSTOATUAL=" . $this->getCampo("PRODUTO_CUSTOATUAL")->getValor();
	 	if($_tipo->getCampo("TIPOMOV_TIPO")->getValor()=='E') {
			$_strSQL .= ",PRODUTO_AC_ENT_QDE=" . $this->getCampo("PRODUTO_AC_ENT_QDE")->getValor() . 
				   		",PRODUTO_AC_ENT_VLR=" . $this->getCampo("PRODUTO_AC_ENT_VLR")->getValor();
	 	} else {
			$_strSQL .=	",PRODUTO_AC_SAIDAS=" . $this->getCampo("PRODUTO_AC_SAIDAS")->getValor();
	 	}
		$_strSQL .= " WHERE PRODUTO_CODIGO=" . $this->getCampo("PRODUTO_CODIGO")->toBD();
		return ($_res=$this->_conn->executaSQL($_strSQL))===false ? false : $this->_conn->getNumRows();
	}
	
	/**
	 * Retorna o SQL para busca dos produtos com estoque abaixo do minimo
	 *
	 * @param string $_ordem
	 * @return string
	 */
	public function produtosAbaixoMinimo($_ordem="DEPTO_CODIGO") {
		return $this->montaSELECT("*","PRODUTO_ESTOQUE<PRODUTO_EST_MINIMO",$_ordem);
	}
	
	/**
	 * Retorna o SQL para busca dos produtos com estoque acima do máximo
	 *
	 * @param string $_ordem
	 * @return string
	 */
	public function produtosAcimaMaximo($_ordem="DEPTO_CODIGO") {
		return $this->montaSELECT("*","PRODUTO_ESTOQUE>PRODUTO_EST_MAXIMO",$_ordem);
	}
}
?>