<?php
/**
 * Definiзгo da classe carro
 * que reflete a entidade carro no banco de dados
 */
/**
 * @internal 
 * CREATE TABLE carro (
 *   codigo integer NOT NULL,
 *   marca character varying(50),
 *   modelo character varying(100),
 *   ano_fabricacao integer,
 *   ano_modelo integer,
 *   cor character varying(20),
 *   CONSTRAINT carros_pkey PRIMARY KEY (codigo)
 * )
 *
 */

class carro extends base {
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->_nome_tabela = 'carro';
		$this->_class_path = 'teste';
		$this->addCampo(new inteiro("CODIGO","Cуdigo",10,null,null,false,false,true,null,null,null,true));
		$this->addCampo(new string("MARCA","Marca",50,null,null,true,true,true,2,null,null,false,$_conn));
		$this->addCampo(new string("MODELO","Modelo",100,null,null,true,true,true,null,null,null,false,$_conn));
		$this->addCampo(new inteiro("ANO_FABRICACAO","Ano de fabricaзгo",4,null,null,true,true,true,null,null,null));
		$this->addCampo(new inteiro("ANO_MODELO","Ano do modelo",4,null,null,true,true,true,null,null,null));
		$this->addCampo(new string("COR","Cor",20,null,null,true,true,true,null,null,null,false,$_conn));
		$this->getCampo("MARCA")->SetComportamento_form("select");
		$this->getCampo("MARCA")->setValor_fixo(
			Array(
				Array('valor'=>'AUDI','label'=>'AUDI'),
				Array('valor'=>'BMW','label'=>'BMW'),
				Array('valor'=>'CHEVROLET','label'=>'CHEVROLET'),
				Array('valor'=>'CITROЛN','label'=>'CITROЛN'),
				Array('valor'=>'FIAT','label'=>'FIAT'),
				Array('valor'=>'FORD','label'=>'FORD'),
				Array('valor'=>'HONDA','label'=>'HONDA'),
				Array('valor'=>'MERCEDES','label'=>'MERCEDES'),
				Array('valor'=>'MITSUBISHI','label'=>'MITSUBISHI'),
				Array('valor'=>'PEUGEOT','label'=>'PEUGEOT'),
				Array('valor'=>'RENAULT','label'=>'RENAULT'),
				Array('valor'=>'TOYOTA','label'=>'TOYOTA'),
				Array('valor'=>'VOLKSWAGEN','label'=>'VOLKSWAGEN'),
				Array('valor'=>'OUTROS','label'=>'OUTROS')
			)
		);
		$this->getCampo("ANO_FABRICACAO")->SetMinimo(date('Y')-10);
		$this->getCampo("ANO_FABRICACAO")->SetMaximo(date('Y'));
		$this->getCampo("ANO_MODELO")->SetMinimo('[ANO_FABRICACAO]');
		$this->getCampo("ANO_MODELO")->SetMaximo(date('Y')+2);
		// AutoComplete
		$this->getCampo("MODELO")->setComportamento_form("ajax");
		$this->getCampo("MODELO")->setCallBack("function(v,qstr) {return '&'+qstr+'&metodo=retornaModelos&marca='" . 
											   "+document.getElementById('MARCA').options[document.getElementById('MARCA').selectedIndex].value;}");
	}
	
	
	protected function validaValor($_campo,$_valor) {
		if($_campo=='MARCA'&&$_valor=='-') {
			return false;
		}
		return true;
	}
	
	
	public function prefiltro() {
		$this->getCampo("MARCA")->setValor_fixo(array_merge(
												Array(Array('label'=>"TODOS",'valor'=>'-')),
												$this->getCampo("MARCA")->getValor_Fixo()));
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
	
	/**
	 * Busca o prуximo cуdigo para o menu
	 *
	 * @return mixed
	 */
	public function incluir() {
		if(($_cod=$this->getProximoCodigo(true))=='[ERRO]') {
			return false;
		} else {
			$this->getCampo("CODIGO")->setValor($_cod);
			$this->getCampo("CODIGO")->setIncluir(true);
			return parent::incluir();
		}
	}

	public function retornaModelos() {
		$_opcoes = Array();
		switch($_POST['marca']) {
		case 'AUDI': 		$_opcoes = Array(
										Array('valor'=>'A3 1.6','label'=>'A3 1.6'),
										Array('valor'=>'A3 1.8','label'=>'A3 1.8'),
										Array('valor'=>'A3 1.8T','label'=>'A3 1.8 Turbo 150cv'),
										Array('valor'=>'A3 1.8T 180','label'=>'A3 1.8 Turbo 180CV'),
										Array('valor'=>'A3 2.0','label'=>'A3 2.0 Aspirado'),
										Array('valor'=>'A4 1.8T','label'=>'A4 1.8 Turbo')
							);
							break;
		case 'VOLKSWAGEN':	$_opcoes = Array(
										Array('valor'=>'GOL 1.0','label'=>'GOL 1.0'),
										Array('valor'=>'GOL 1.6','label'=>'GOL 1.6'),
										Array('valor'=>'GOL 1.8','label'=>'GOL 1.8'),
										Array('valor'=>'GOL 1.8 GT','label'=>'GOL GT 1.8'),
										Array('valor'=>'GOLF 1.6','label'=>'GOLF 1.6'),
										Array('valor'=>'GOLF 1.8 GTS','label'=>'GOLF 1.8 GTS')
							);
							break;
		case 'FIAT':		$_opcoes = Array(
										Array('valor'=>'PUNTO 1.4','label'=>'PUNTO 1.4'),
										Array('valor'=>'PUNTO 1.8 SPORTING','label'=>'PUNTO 1.8 Sporting'),
										Array('valor'=>'PUNTO 1.4 T-JET','label'=>'PUNTO T-Jet')
							);
							break;
		}
		$_resultado = Array();
		foreach($_opcoes as $_opcao) {
			if(stripos($_opcao['label'],$_POST['valor'])!==false) {
				$_resultado[] = $_opcao;
			}
		}
		return $this->retornaListAjax($_resultado);
	}
}
?>