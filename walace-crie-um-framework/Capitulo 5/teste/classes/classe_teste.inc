<?php
/**
 * Classe de Testes
 *
 */
class teste extends BASE {
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->_nome_tabela = 'tab_teste';
		$this->_class_path = "teste"; 
		$this->addCampo(new inteiro("CODIGO","Cуdigo",10,null,null,true,false,true,null,null,null,true));
		$this->addCampo(new string("DESCRICAO","Descriзгo",50,null,null,true,true,true,null,null,null,false,$_conn));
		$this->addCampo(new dinheiro("VALOR","Valor",12,null,null,true,true,true,'0,05','8999,99',null,false));
		$this->addCampo(new string("ATIVO","Registro Ativo",1,null,null,true,true,false,null,null,null,false,$_conn));
		$this->getCampo("ATIVO")->setComportamento_form("checkbox");
		$this->getCampo("ATIVO")->setMarcar(true);
		$this->getCampo("ATIVO")->setValor_Fixo("S");
		$this->addCampo(new data("DATA","Data de Entrada",12,null,null,true,true,false,'NOW','31-12-2009',null,false,$_conn));
		$this->addCampo(new inteiro("AJAX","Cуdigo de Referкncia",30,null,null,true,true,false,null,'[CODIGO]',null,false,$_conn));
		$this->getCampo("AJAX")->setComportamento_form("ajax");
		$this->getCampo("CODIGO")->setComportamento_form("proximo");
		$this->getCampo("DATA")->setObrigatorio(false);
	}
	
	/**
	 * Retorna o comando SQL para geraзгo do 
	 * conjunto de dados resultante da busca AJAX
	 *
	 * @return string
	 */
	public function montaSQLAjax() {
		return "SELECT CODIGO,DESCRICAO FROM {$this->_nome_tabela} WHERE " . 
			 	" CODIGO=" . ((int) $_POST['valor']) . 
				" OR LOWER(DESCRICAO) LIKE '%" . strtolower($_POST['valor']) . "%' " . 
				"ORDER BY DESCRICAO,CODIGO";
	}
	
	/**
	 * Retorna o comando SQL necessбrio para
	 * a busca do prуximo cуdigo
	 *
	 * @return string
	 */
	public function montaSQLProximoCodigo() {
		return "SELECT MAX(CODIGO) AS CODIGO FROM {$this->_nome_tabela}";
	}
}
?>