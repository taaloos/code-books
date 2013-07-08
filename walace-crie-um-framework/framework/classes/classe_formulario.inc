<?php
/**
 * Classe para gerenciamento de formulários
 *
 */
class formulario extends tag {
	
	public function __construct($_nome,$_acao,$_metodo="POST") {
		parent::__construct(new tipotag("FORM"),
							Array(new atributo("NAME",$_nome),new atributo("ID",$_nome),
								  new atributo("ACTION",$_acao),new atributo("METHOD",$_metodo),
								  new atributo("ONSUBMIT","return objForm.estaOk();")));
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
	
	public function setEventos(Eventos $_eventos) {
		$this->_eventos = $_eventos;
	}
	
	public function clearEventos() {
		$this->_eventos = null;
	}
	
	public function getEventos() {
		return $this->_eventos;
	}
	
	public function toHTML($_ot=true,$_spc=" ") {
		if($this->_eventos instanceof Eventos) {
			foreach($this->_eventos->getEventos() as $_evento) {
				$this->addAtributo($_evento);
			}
		}
		return parent::toHTML($_ot,$_spc);
	}

	public function setVerificaCampo($_tipocpo) {
		$this->addAtributo(new atributo("onKeyPress","return objForm.verificaCampo(event,'{$_tipocpo}',this);"));
	}
	
	public function setValidaCampo($_tipocpo,$_nome,$_label,$_min=0,$_max=0,$_ob=true) {
		$_obrig = ($_ob===true ? 1 : 0);
		$this->addSubTag(new tag(new tipotag("SCRIPT"),null,"objForm.addCampo('{$_nome}','{$_label}','{$_tipocpo}','{$_min}','{$_max}','{$_obrig}');"));
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
	
	public function marcar($_marcar=false) {
		foreach($this->getAtributos() as $_chv=>$_attr) {
			if($_attr->getNome()=="CHECKED") {
				$this->deleteAtributo($_chv);
			}
		}
		if($_marcar===true) {
			$this->addAtributo(new atributo("CHECKED"));
		}
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
	
	public function marcar($_marcar=false) {
		foreach($this->getAtributos() as $_chv=>$_attr) {
			if($_attr->getNome()=="CHECKED") {
				$this->deleteAtributo($_chv);
			}
		}
		if($_marcar===true) {
			$this->addAtributo(new atributo("CHECKED"));
		}
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

class formInputSubmit extends formCampo {
	public function __construct($_nome,$_valor=' Enviar ',$_classe=null,Eventos $_eventos=null) {
		parent::__construct(new tipotag("INPUT",false),
							Array(new atributo("TYPE","SUBMIT"),
								  new atributo("VALUE",$_valor)),$_nome,$_classe,$_eventos);
	}
}

class formInputReset extends formCampo {
	public function __construct($_nome,$_valor=' Desfazer ',$_classe=null,Eventos $_eventos=null) {
		parent::__construct(new tipotag("INPUT",false),
							Array(new atributo("TYPE","RESET"),
								  new atributo("VALUE",$_valor)),$_nome,$_classe,$_eventos);
	}
}

class formInputHidden extends formCampo {
	public function __construct($_nome,$_valor) {
		parent::__construct(new tipotag("INPUT",false),
							Array(new atributo("TYPE","HIDDEN"),
								  new atributo("VALUE",$_valor)),$_nome,null,null);
	}
}

class formButton extends formCampo {
	public function __construct($_nome,$_src,$_texto="",$_tipo="BUTTON",$_width=null,$_height=null,$_classe=null,Eventos $_eventos=null) {
		parent::__construct(new tipotag("BUTTON"),
							Array(new atributo("TYPE",$_tipo)),$_nome,$_classe,$_eventos);
		$this->setValor($_texto);
		if($_src!==null) {
			$this->addImagem($_src,$_width,$_height);
		}
	}
	
	public function addImagem($_src,$_width=null,$_height=null) {
		$_atributos[] = new atributo("SRC",$_src);
		if($_width!==null) {
			$_atributos[] = new atributo("WIDTH",$_width);
		}
		if($_height!==null) {
			$_atributos[] = new atributo("HEIGHT",$_height);
		}
		$this->addSubTag(new tag(new tipotag("IMG",false),$_atributos));
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
			$this->addOpcao($_opcao);
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

class formTextArea extends formCampo {
	public function __construct($_nome,$_linhas=5,$_colunas=70,$_classe=null,Eventos $_eventos=null) {
		parent::__construct(new tipotag("TEXTAREA"),
							Array(new atributo("ROWS",$_linhas),
								  new atributo("COLS",$_colunas)),$_nome,$_classe,$_eventos);
	}
	
}

?>