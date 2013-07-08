<?php
/**
 * Classe Base do framework, deverб ser estendida nas classes filhas
 *
 */
class BASE {
	protected $_nome_tabela;
	protected $_campos = Array();
	/**
	 * @var BancoDados
	 */
	protected $_conn = null;
	
	public function __construct(BancoDados &$_conn=null) {
		$this->_conn = $_conn;
	}
	
	public function addCampo(campo $_campo) {
		$this->_campos[$_campo->getNome()] = $_campo;
	}
	
	public function deleteCampo($_campo) {
		unset($this->_campos[$_campo]);
	}
	
	public function clearCampos() {
		$this->_campos = Array();
	}
	
	public function getCampo($_campo) {
		return $this->_campos[$_campo];
	}
	
	public function getListaCampos() {
		return array_keys($this->_campos);
	}
	
	public function filtrarCampos($_filtro="listar",$_valor=true) {
		$_campos = Array();
		foreach($this->_campos as $_campo) {
			$_fcn = "get{$_filtro}";
			if($_campo->$_fcn()===$_valor) {
				$_campos[$_campo->getNome()] = $_campo;
			}
		}
		return $_campos;
	}
	
	public function montaSELECT($_campos,$_where=null,$_orderby=null,$_limit=null,$_extras=null) {
		return "SELECT {$_campos} FROM {$this->_nome_tabela} " . 
				($_where!==null ? "WHERE {$_where}" : "") .
				($_orderby!==null ? " ORDER BY {$_orderby}" : "") . 
				($_extras!==null ? " {$_extras}" : "") . 
				($_limit!==null ? " LIMIT {$_limit}" : ""); 
	}
	
	public function listar() {
		$_camposlista = array_merge($this->filtrarCampos(),$this->filtrarCampos("pk")); // Campos que serгo exibidos na listagem
		// 1a. Tarefa, buscar o Total de Registros, mas somente na primeira VEZ...
		if(!isset($_GET['pagina'])) {
			$_strSQL = $this->montaSELECT("COUNT(*) AS TOTAL");
			$_total_registros = 0;
			if($this->_conn->executaSQL($_strSQL)!==false) {
				$_dados = $this->_conn->proximo();
				$_total_registros = $_dados['TOTAL'];
			}
		} else {
			$_total_registros = $_GET['total_registros'];
		}
		$_limit = $this->_conn->getLimit(paginacao::getLimit(isset($_GET['pagina']) ? $_GET['pagina'] : 1)); 
		$_strSQL = $this->montaSELECT(implode(",",array_keys($_camposlista)),null,implode(",",array_keys($this->filtrarCampos("pk"))),$_limit);
		$_tipos = new tipospadrao();
		$_tab = new tag($_tipos->getTipo('TABLE'),Array(new atributo("BORDER",0),
														new atributo("CELLPADDING",5),
														new atributo("STYLE","border:1px solid #a0a0a0;border-collapse:collapse;"),
														new atributo("WIDTH","100%")));
		$_tr  = new tag($_tipos->getTipo('TR'));
		foreach($_camposlista as $_campo) {
			$_tr->addSubTag(new tag($_tipos->getTipo('TH'),Array(new atributo("STYLE","border:1px solid #a0a0a0;background-color:#f0f0f0;")),
									$_campo->getTitulo()));
		}
		$_tab->addSubTag($_tr);
		if($this->_conn->executaSQL($_strSQL)!==false&&$this->_conn->getNumRows()>0) {
			while($this->proximo()) {
				$_tab->addSubtag(new tag($_tipos->getTipo('TR')));
				$_pk = "";
				foreach($_camposlista as $_campo) {
					if($_campo->getPK()===true) {
						$_pk .= "&{$_campo->getNome()}={$_campo->toHTML()}";
					}
					$_tab->getLastSubTag()->addSubTag(new tag($_tipos->getTipo('TD'),
												  Array(new atributo("STYLE","border:1px solid #a0a0a0;"),$_campo->getAtributosExtras()),
												  $_campo->toHTML()));
				}
			}
			$_trf = new tag($_tipos->getTipo('TR'));
			$_trf->addSubTag(new tag($_tipos->getTipo("TD"),Array(new atributo("COLSPAN",sizeof($_camposlista)),
																  new atributo("STYLE","color:#a0a0a0;font-size:11px;border:1px solid #a0a0a0;")),
									 "Total de {$_total_registros} Registro(s)"));
			$_tab->addSubTag($_trf);
		} else {
			$_trf = new tag($_tipos->getTipo('TR'));
			$_trf->addSubTag(new tag($_tipos->getTipo("TD"),Array(new atributo("COLSPAN",sizeof($_camposlista)),
																  new atributo("STYLE","border:1px solid #a0a0a0;text-align:center")),
									 "Nenhum Registro"));
			$_tab->addSubTag($_trf);
			
		}
		$_html = "";
		// suporte a AJAX
		if(!isset($_GET['pagina'])) {
			$_scrAjax = new tag($_tipos->getTipo('SCRIPT'),Array(new Atributo("SRC","framework/javascript/ajax.js")));
			$_scr = new tag($_tipos->getTipo('SCRIPT'),null,paginacao::getChamadaAjax());
			$_html = $_scrAjax->toHTML(false) . $_scr->toHTML(false);
		} 
		$_div = new tag($_tipos->getTipo('DIV'),Array(new Atributo('ID','PAGINACAO')));
		$_div->addSubTag($_tab);
		$_pag = new tag($_tipos->getTipo("P"),Array(new atributo("ALIGN","CENTER")));
		$_pag->setValor(implode(" ",paginacao::paginar($_total_registros,(isset($_GET['pagina']) ? $_GET['pagina'] : 1),null,true)));
		$_div->addSubTag($_pag);
		$_html .= $_div->toHTML();
		return (!isset($_GET['pagina']) ? $_html : utf8_encode($_html));
	}	
	
	public function preenche($_d) {
		foreach($this->_campos as $_k=>$_campo) {
			$this->_campos[$_k]->SetValor($_d[$_k]);
		}
	}
	
	public function proximo()  {
		if(($_d=$this->_conn->proximo())!==false) {
			$this->preenche($_d);
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Busca registros no banco de dados
	 *
	 * @param array $_valores
	 */
	public function Buscar($_valores=null) {
		$_pk = $this->filtrarCampos("pk");
		$_where = null;
		if($_valores!==null) {
			// Gerar a clasula where
			$_where = "";
			foreach($_pk as $_nome=>$_campo) {
				if(isset($_valores[$_nome])) {
					$_campo->setValor($_valores[$_nome]);
					$_where .= ($_where!='' ? " AND " : "") . "{$_nome}=" . $_campo->toBD();
				}
			}
		}
		if($this->_conn->executaSQL($this->montaSELECT("*",$_where,implode(",",array_keys($_pk))))===false) {
			return false;
		} else {
			return $this->_conn->getNumRows();
		}
	}
	
	/**
	 * Inclui um registro na tabela relacionada
	 *
	 * @return mixed (false = erro)
	 */
	public function incluir() {
		$_listacampos = Array();
		$_listavalores = Array();
		foreach($this->filtrarCampos("incluir") as $_campo) {
			if($_campo->getValor()!==null) {
				$_listacampos[]  = $_campo->getNome();
				$_listavalores[] = $_campo->toBD();
			}
		}
		$_strSQL = "INSERT INTO {$this->_nome_tabela} (" . 
					implode(",",$_listacampos) . ") VALUES(" . 
					implode(",",$_listavalores) . ")";
		if($this->_conn->executaSQL($_strSQL)!==false) {
			return $this->_conn->getNumRows();
		} else {
			return false;
		}
	}
	
	/**
	 * Altera um registro na tabela relacionada
	 *
	 * @return mixed (false = erro)
	 */
	public function alterar() {
		$_listacampos = "";
		$_listachave = "";
		$_pk = $this->filtrarCampos("pk");
		foreach($_pk as $_nome=>$_campo) {
			$_listachave .= ($_listachave!="" ? " AND " : "") . "{$_nome}=" . $_campo->toBD();
		}
		foreach($this->filtrarCampos("alterar") as $_nome=>$_campo) {
			if($_campo->getValor()!==null&&!key_exists($_nome,$_pk)) {
				$_listacampos .= ($_listacampos!="" ? "," : "") . "{$_nome}=" . $_campo->toBD();
			}
		}
		$_strSQL = "UPDATE {$this->_nome_tabela} SET {$_listacampos} WHERE {$_listachave}";
		if($this->_conn->executaSQL($_strSQL)!==false) {
			return $this->_conn->getNumRows();
		} else {
			return $this->_conn->getUltimoErro();
		}
		
	}
	
	/**
	 * Exclui um Registro (somente 1)
	 *
	 * @return mixed (false = erro)
	 */
	public function excluir() {
		$_listachave = "";
		$_pk = $this->filtrarCampos("pk");
		foreach($_pk as $_nome=>$_campo) {
			$_listachave .= ($_listachave!="" ? " AND " : "") . "{$_nome}=" . $_campo->toBD();
		}
		$_strSQL = "DELETE FROM {$this->_nome_tabela} WHERE {$_listachave}";
		if($this->_conn->executaSQL($_strSQL)!==false) {
			return $this->_conn->getNumRows();
		}
	}
	
	public function getConn() {
		return $this->_conn;
	}
	
}

/**
 * Classe abstrata para gerenciamento de Campos do framework
 *
 */
abstract class campo {
	protected $_nome;
	protected $_titulo;
	protected $_tipo;
	protected $_tamanho;
	protected $_formato;
	protected $_relacao;
	protected $_incluir;
	protected $_alterar;
	protected $_listar;
	protected $_minimo;
	protected $_maximo;
	protected $_camporef;
	protected $_valor;
	protected $_valor_anterior;
	protected $_pk;
	/**
	 * @var BancoDados $_conn
	 */
	protected $_conn = null;
	
	abstract public function toBD();
	abstract public function toHTML();
	
	/**
	 * Construtor da classe
	 *
	 * @param string  $_nome
	 * @param string  $_titulo
	 * @param string  $_tipo
	 * @param integer $_tamanho
	 * @param string  $_formato
	 * @param string  $_relacao
	 * @param bool    $_incluir
	 * @param bool 	  $_alterar
	 * @param bool    $_listar
	 * @param string  $_minimo
	 * @param string  $_maximo
	 * @param string  $_camporef
	 * @param bancodado $_conn
	 */
	public function __construct($_nome,$_titulo,$_tipo,$_tamanho,$_formato,$_relacao,
								$_incluir=true,$_alterar=true,$_listar=true,$_minimo=null,
								$_maximo=null,$_camporef=null,$_pk=false,bancodados &$_conn=null) {
		$this->_nome 		= $_nome;
		$this->_tipo		= $_tipo;
		$this->_titulo 		= $_titulo;
		$this->_tamanho 	= $_tamanho;								
		$this->_formato		= $_formato;
		$this->_relacao		= $_relacao;
		$this->_incluir		= (bool) $_incluir;
		$this->_alterar		= (bool) $_alterar;
		$this->_listar		= (bool) $_listar;
		$this->_minimo		= $_minimo;
		$this->_maximo		= $_maximo;
		$this->_camporef	= $_camporef;
		$this->_valor		= null;
		$this->_conn		= $_conn;
		$this->_pk			= (bool) $_pk;
	}
	
	public function getAtributosExtras() {
		return new atributo("ALIGN","LEFT");
	}
	
	/* Funзгo Genйrica para Chamada de mйtodos inexistentes na classe */
	/* Formato do Nome: [Set|Get][Nome_Atributo]([Valor]) */
	public function __call($_metodo,$_valores) {
		$_m = strtolower($_metodo);
		switch (substr($_m,0,3))  {
			case 'get':
			case 'set':	$_atributo = "_" . substr($_m,3);
						if(property_exists($this,$_atributo)) {
							if(substr($_m,0,3)=='set') {
								$this->{$_atributo} = $_valores[0];
								return True;
							} else {
								return $this->{$_atributo};
							}
						} else {
							return false;
						}
						break;
		}
	}
	
}

/**
 * Classe para gerenciamento de campos do tipo string
 *
 */
class string extends campo {
	public function __construct($_nome,$_titulo,$_tamanho,$_formato,$_relacao,
								$_incluir=true,$_alterar=true,$_listar=true,$_minimo=null,
								$_maximo=null,$_camporef=null,$_pk=false,bancodados &$_conn=null) {

		parent::__construct($_nome,$_titulo,'STR',$_tamanho,$_formato,$_relacao,
								$_incluir,$_alterar,$_listar,$_minimo,
								$_maximo=null,$_camporef,$_pk,$_conn);
	}
	
	public function toBD() {
		return "'" . $this->_conn->EscapeString($this->_valor) . "'";
	}
	
	public function toHTML() {
		return $this->_valor;
	}
	
}

/**
 * Classe para gerenciamento de campos numйricos
 *
 */
class numero extends campo {
	protected $_casas_decimais = 99;
	
	public function __construct($_nome,$_titulo,$_tipo,$_tamanho,$_formato,$_relacao,
								$_incluir=true,$_alterar=true,$_listar=true,$_minimo=null,
								$_maximo=null,$_camporef=null,$_pk=false) {

		parent::__construct($_nome,$_titulo,$_tipo,$_tamanho,$_formato,$_relacao,
								$_incluir,$_alterar,$_listar,$_minimo,
								$_maximo=null,$_camporef=null,$_pk);
	}
	
	public function toBD() {
		return number_format(str_replace(",",".",str_replace(".","",$this->_valor)),$this->_casas_decimais,".","");
	}
	
	public function toHTML() {
		return number_format($this->_valor,$this->_casas_decimais,",","");
	}
	
	public function getAtributosExtras() {
		return new atributo("ALIGN","RIGHT");
	}
}

/**
 * Classe derivada da classe numero para gerenciar inteiros
 *
 */
class inteiro extends numero {
	public function __construct($_nome,$_titulo,$_tamanho,$_formato,$_relacao,
								$_incluir=true,$_alterar=true,$_listar=true,$_minimo=null,
								$_maximo=null,$_camporef=null,$_pk=false) {

		parent::__construct($_nome,$_titulo,'INT',$_tamanho,$_formato,$_relacao,
								$_incluir,$_alterar,$_listar,$_minimo,
								$_maximo=null,$_camporef=null,$_pk);
		$this->_casas_decimais = 0;
	}
}


/**
 * Classe derivada da classe numero para gerenciar nъmero de ponto flutuante
 *
 */
class float extends numero {
	public function __construct($_nome,$_titulo,$_tamanho,$_formato,$_relacao,
								$_incluir=true,$_alterar=true,$_listar=true,$_minimo=null,
								$_maximo=null,$_camporef=null,$_pk=false,$_casas=3) {

		parent::__construct($_nome,$_titulo,'FLT',$_tamanho,$_formato,$_relacao,
								$_incluir,$_alterar,$_listar,$_minimo,
								$_maximo=null,$_camporef=null,$_pk);
		$this->_casas_decimais = $_casas;
	}
}

/**
 * Classe derivada da classe numero para gerenciar valores de Dinheiro
 *
 */
class dinheiro extends numero {
	public function __construct($_nome,$_titulo,$_tamanho,$_formato,$_relacao,
								$_incluir=true,$_alterar=true,$_listar=true,$_minimo=null,
								$_maximo=null,$_camporef=null,$_pk=false) {

		parent::__construct($_nome,$_titulo,'CUR',$_tamanho,$_formato,$_relacao,
								$_incluir,$_alterar,$_listar,$_minimo,
								$_maximo=null,$_camporef=null,$_pk);
		$this->_casas_decimais = 2;
	}
}


/**
 * Classe para gerenciar campos do tipo data (sem informaзгo de hora)
 *
 */
class data extends campo {
	public function __construct($_nome,$_titulo,$_tamanho,$_formato,$_relacao,
								$_incluir=true,$_alterar=true,$_listar=true,$_minimo=null,
								$_maximo=null,$_camporef=null,$_pk=false,bancodados &$_conn=null) {

		parent::__construct($_nome,$_titulo,'DATE',$_tamanho,$_formato,$_relacao,
								$_incluir,$_alterar,$_listar,$_minimo,
								$_maximo=null,$_camporef=null,$_pk,$_conn);
	}
	
	public function toBD() {
		return $this->_conn->converteDataToBD($this->_valor);
	}
	
	public function toHTML() {
		return $this->_conn->converteDataToHTML($this->_valor);
	}
}

/**
 * Classe para gerenciar campos do tipo data e hora
 *
 */
class datahora extends campo {
	public function __construct($_nome,$_titulo,$_tamanho,$_formato,$_relacao,
								$_incluir=true,$_alterar=true,$_listar=true,$_minimo=null,
								$_maximo=null,$_camporef=null,$_pk=false,bancodados &$_conn=null) {

		parent::__construct($_nome,$_titulo,'DTIME',$_tamanho,$_formato,$_relacao,
								$_incluir,$_alterar,$_listar,$_minimo,
								$_maximo=null,$_camporef=null,$_pk,$_conn);
	}
	
	public function toBD() {
		return $this->_conn->converteDataHoraToBD($this->_valor);
	}
	
	public function toHTML() {
		return $this->_conn->converteDataHoraToHTML($this->_valor);
	}
}

?>