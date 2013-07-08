<?php
/**
 * Classe para gerenciamento de formulários
 *
 */
class formulario extends tag {
	
	public function __construct($_nome,$_action,$_metodo="POST") {
		parent::__construct(new tipotag("FORM"),
							Array(new atributo("NAME",$_nome),new atributo("ID",$_nome),
								  new atributo("ACTION",$_action),new atributo("METHOD",$_metodo)));
	}
	
}

class formCampo extends tag {
	protected $_eventos=null;
	
	public function __construct($_tipo,$_atributos,$_nome,$_classe,$_eventos) {
		parent::__construct($_tipo,$_atributos);
		$this->addAtributo(new atributo("NAME",$_nome));
		$this->addAtributo(new atributo("ID",$_nome));
		if($_classe!==null) {
			$this->addAtributo(new atributo("CLASS",$_classe));
		}
		if($_eventos!==null) {
			$this->_eventos = $_eventos;
		}
	}
	
	public function addEventos(Evento $_eventos) {
		$this->_eventos = $_eventos;
	}
	
	public function toHTML($_ot=true,$_spc=" ") {
		if($this->_eventos!==null) {
			foreach($this->_eventos as $_evento) {
				$this->addAtributo($_evento);
			}
		}
		return parent::toHTML($_ot,$_spc);
	}
	
}

class formInputTexto extends formCampo {
	public function __construct($_nome,$_tipo='STR',$_tamanho=30,$_maximo=30,$_classe=null,Eventos $_eventos=null) {
		parent::__construct(new tipotag("INPUT",false),
							Array(new atributo("TYPE","TEXT"),
								  new atributo("SIZE",$_tamanho),
								  new atributo("MAXLENGTH",$_maximo)),$_nome,$_classe,$_eventos);
		switch($_tipo) {
			case 'INT':
			case 'FLOAT':
			case 'CUR':		$this->addAtributo(new atributo("STYLE","text-align:right;padding-right:2px;"));
		}
	}
}

class formInputPassword extends formCampo {
	public function __construct($_nome,$_tamanho=30,$_maximo=30,$_classe=null,Eventos $_eventos=null) {
		parent::__construct(new tipotag("INPUT",false),
							Array(new atributo("TYPE","PASSWORD"),
								  new atributo("SIZE",$_tamanho),
								  new atributo("MAXLENGTH",$_maximo)),$_nome,$_classe,$_eventos);
	}
}

class formInputCheckBox extends formCampo {
	public function __construct($_nome,$_valor,$_texto=null,$_classe=null,Eventos $_eventos=null,$_marcar=false) {
		parent::__construct(new tipotag("INPUT",false),
							Array(new atributo("TYPE","CHECKBOX"),
								  new atributo("VALUE",$_valor)),$_nome,$_classe,$_eventos);
		if($_marcar===true) {
			$this->addAtributo(new atributo("CHECKED"));
		}
		$this->setValor($_texto);
	}
	
	public function marcar() {
		$this->addAtributo(new atributo("CHECKED"));
	}
}

class formInputRadio extends formCampo {
	public function __construct($_nome,$_valor,$_texto=null,$_classe=null,Eventos $_eventos=null,$_marcar=false) {
		parent::__construct(new tipotag("INPUT",false),
							Array(new atributo("TYPE","RADIO"),
								  new atributo("VALUE",$_valor)),$_nome,$_classe,$_eventos);
		if($_marcar===true) {
			$this->addAtributo(new atributo("CHECKED"));
		}
		$this->setValor($_texto);
	}
	
	public function marcar() {
		$this->addAtributo(new atributo("CHECKED"));
	}
}

class formInputFile extends formCampo {
	public function __construct($_nome,$_tamanho=30,$_maximo=30,$_classe=null,Eventos $_eventos=null) {
		parent::__construct(new tipotag("INPUT",false),
							Array(new atributo("TYPE","FILE"),
								  new atributo("SIZE",$_tamanho),
								  new atributo("MAXLENGTH",$_maximo)),$_nome,$_classe,$_eventos);
	}
}

class formInputHidden extends formCampo {
	public function __construct($_nome,$_valor) {
		parent::__construct(new tipotag("INPUT",false),
							Array(new atributo("TYPE","HIDDEN"),
								  new atributo("VALUE",$_valor)),$_nome,null,null);
	}
}

class formInputButton extends formCampo {
	public function __construct($_nome,$_src,$_width=null,$_height=null,$_border=0,$_classe=null,Eventos $_eventos=null) {
		parent::__construct(new tipotag("BUTTON"),
							Array(new atributo("TYPE","BUTTON")),$_nome,$_classe,$_eventos);
		$_atributos[] = new atributo("SRC",$_src);
		if($_width!==null) {
			$_atributos[] = new atrbituto("WIDTH",$_width);
		}
		if($_height!==null) {
			$_atributos[] = new atrbituto("HEIGHT",$_height);
		}
		$this->addSubTag(new tag(new tipotag("IMG",false),$_atributos));
	}
}

class formInputSubmit extends formCampo {
	public function __construct($_nome,$_valor,$_classe=null,Eventos $_eventos=null) {
		parent::__construct(new tipotag("INPUT"),
							Array(new atributo("TYPE","SUBMIT"),
								  new atributo("VALUE",$_valor)),$_nome,$_classe,$_eventos);
	}
}

class formSelect extends formCampo {
	public function __construct($_nome,$_multi=false,$_opcoes=Array(),$_classe=null,Eventos $_eventos=null) {
		parent::__construct(new tipotag("SELECT"),null,$_nome,$_classe,$_eventos);
		if($_multi===true) {
			$this->addAtributo(new atributo("MULTIPLE"));
			$this->addAtributo(new atributo("SIZE",10));
		}
		foreach($_opcoes as $_opcao) {
			$this->addSubTag(new tag(new tipotag("OPTION"),Array(new atributo("VALUE",$_opcao['valor'])),$_opcao['label']));
			if($_opcao['selecionado']===true) {
				$this->getLastSubTag()->addAtributo(new atributo('SELECTED'));
			}
		}
	}
	
	public function addOpcao($_opcao) {
		$this->addSubTag(new tag(new tipotag("OPTION"),Array(new atributo("VALUE",$_opcao['valor'])),$_opcao['label']));
			if($_opcao['selecionado']===true) {
				$this->getLastSubTag()->addAtributo(new atributo('SELECTED'));
			}
	}
	
	public function marcarOpcao($_opcao) {
		foreach($this->_subtags as $_subtag) {
			foreach($_subtag->getAtributos() as $_atributo) {
				if($_atributo->getValor()==$_opcao) {
					$_subtag->addAtributo(new atributo("SELECTED"));
				}
			}
		}
	}
}

?>