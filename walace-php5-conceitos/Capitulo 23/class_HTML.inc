<?php
	class HTML {
		/* Atributos privativos */ 
    	private $html;
	  	private $att;
	  	private $text;
	  	private $tipostag;
	  	private $_idtipo;
	  	private $_tagid;
	  	private $_flgend;

		/* Contrutor */	  
	  	function __construct($tipo=0,$att=Array(),$end=FALSE) {
			$this->html = Array();
			$this->att  = Array();
			$this->_flgend = Array();
			$this->_tagid = -1;
			$this->_idtipo = 0;
			$this->Addtipotag("HTML");
			$this->Addtipotag("HEAD");
			$this->Addtipotag("TITLE");
			$this->Addtipotag("BODY");
			$this->Addtipotag("TABLE");
			$this->Addtipotag("TR");
			$this->Addtipotag("TD");
			$this->Addtipotag("A");
			$this->Addtipotag("BR",FALSE);
			$this->Addtipotag("FORM");
			$this->Addtipotag("INPUT",FALSE);
			$this->Addtipotag("SELECT");
			$this->Addtipotag("OPTION");
			$this->Addtipotag("TEXTAREA");
			$this->Addtipotag("IMG",FALSE);
			$this->AddTipotag("DIV");
			$this->AddTipotag("SPAN");
			$this->AddTipotag("BUTTON");
			$this->AddTipotag("SCRIPT");
			$this->AddTipotag("P");		 
			if($tipo!=0) {
				$this->AddTag($tipo,$att,$end);
			}
	  	}			   
		
		/* métodos privativos */
		/* métodos protegidos */
		
		/* Métodos públicos */
		public function Addtipotag($_desc_tipo,$_flgEnd=TRUE) {
			$this->_idtipo++;
			$this->tipostag[$this->_idtipo] = $_desc_tipo;
			$this->tipostag[$_desc_tipo] = $_desc_tipo;
			$this->_flgend[$this->_idtipo] = $_flgEnd;
			$this->_flgend[$_desc_tipo] = $_flgEnd;
			return $this->_idtipo; 
	  	}
	  
		public function AddTag($tipo,$att=Array(),$end=FALSE,$text="") {
			$this->StartTag($tipo,$att,$end);
			if($text!="") {
				$this->AddText($this->_tagid,$text);
			}
			if($end) {
				$this->EndTag($this->_tagid);
			}
			return $this->_tagid;
	  	}
	  
	  	public function StartTag($tipo,$att=Array()) {
	     	$this->_tagid++;
	     	$this->html[$this->_tagid][0] = FALSE;
		 	if($this->_flgend[$tipo]===FALSE) {
		   		$this->html[$this->_tagid][0] = TRUE;
		 	}
		 	$this->html[$this->_tagid][1] = $this->tipostag[$tipo];
		 	$this->html[$this->_tagid][2] = 0; // Start
		 	$this->AddAtt($this->_tagid,$att);
		 	return $this->_tagid;
	  	}
	  
	  	public function AddAtt($id,$att=Array()) {
	    	if(!is_array($att)) {
		  		return FALSE;
			}
			elseif($this->html[$id][0]===NULL OR $this->html[$id][1]==NULL) {
		  		return FALSE;
			} else {
		   		foreach($att as $key=>$vlr) {
		     		$this->att[$id][$key] = $vlr;
		   		}
			}
	  	}
	  
	  	public function AddText($id,$text="",$clear=FALSE) {
	    	if($clear) {
		   		$this->text[$id] = "";
			}
			$this->text[$id] .= $text;
	  	}
	  
	  	public function EndTag($id) {
	    	if($this->html[$id][0]===TRUE) { 
		  		return FALSE;
			} elseif($this->html[$id][1]!=NULL) {
		  		$this->html[$id][0] = TRUE;
		  		$this->StartTag($this->html[$id][1]);
		  		$this->html[$this->_tagid][0] = TRUE; 
		  		$this->html[$this->_tagid][2] = 1; // end
		  		return TRUE;
			} else {
		  		return FALSE;
			}
	  	}
	  
	  	public function toHTML() {
	    	if($this->_tagid==-1) {
		  		return FALSE;
			} else {
		   		$htmltext = "";
		   		foreach($this->html as $key=>$vlr) {
		      		if($vlr[0]==FALSE) {
			    		$htmltext = "<p>ERRO na Estrutura.. Falta fechar a tag.." . 
				            		$this->tipostag[$vlr[1]] . " (id #" . $key . ")</p>";
						return $htmltext;
			  		}
		      		if($vlr[2]==0) {
			     		// Start
				 		$htmltext.= "<" . $vlr[1];
				 		if(is_Array($this->att[$key])) {
				   			foreach($this->att[$key] as $att=>$vlr) {
				     			if($att=="_") {
					    			$htmltext.= " " . $vlr;
					 			} else {
				       				$htmltext.= " " . $att . "=\"" . $vlr . "\"";
					 			}
				   			}
				 		}
				 		$htmltext.= ">";
				 		if($this->text[$key]!="") {
				   			$htmltext.= $this->text[$key];
				 		}
			  		}
			  		if($vlr[2]==1) {
			    		// End
						if($this->_flgend[$vlr[1]]===TRUE) {
				   			$htmltext.= "</" . $vlr[1] . ">";
						}
						if($vlr!="IMG") $htmltext.="\n";
			  		}
		   		}
		   		return $htmltext;
			}
	   	 	return FALSE;
	  	}
		/* Fim dos métodos públicos */
   	}
   
   
   
   /* gera uma tabela HTML (header+detalhes+footer) */
   class TABELA Extends HTML {
   		/* atributos privativos */
		private $_id_tabela = NULL;
		private	$_header = FALSE;
		private $_footer = FALSE;

		/* atributos protegidos */
   		protected $_num_cols = 0;
		protected $_cor_fundo_header = "#d4d0c8";
		protected $_cor_fundo_detalhe = "#ffffff";
		protected $_cor_fonte_header = "#000000";
		protected $_cor_fonte_detalhe = "#000000";
		protected $_fonte = "Verdana";
		protected $_extras = "";
		
		
		/* Construtor */
		function __construct($_gera_tabela=TRUE,$_width="100%") {
			parent::__construct();
			if($_gera_tabela) {
				$this->AddTabela($_width); 
			}
		}
		

		/* métodos privativos */
		private function AddTRTD($_valores,$_tipo=0,$_colspan=FALSE) {
			$_st = "font: {$this->_fonte};";
			if($_tipo==0) { 
				// Header
				$_st .= "color: {$this->_cor_fonte_header};";
				$_st .= "background-color: {$this->_cor_fundo_header};";
			} else {
				// Detalhe
				$_st .= "color: {$this->_cor_fonte_header_detalhe};";
				$_st .= "background-color: {$this->_cor_fundo_detalhe};";
			}
			$_st .= $this->_extras;  // complemento do estilo (css)
			$_id = $this->AddTag("TR",Array("style"=>$_st));
			if($_colspan===FALSE) {
				foreach($_valores as $_vlr) {
					$this->AddTag("TD",Array("style"=>$_st),TRUE,$_vlr);
				}
			} else {
				$this->AddTag("TD",Array("style"=>$_st,"colspan"=>$this->_num_cols),TRUE,$_valores);
			}
			$this->EndTag($_id);
		}
		/* Fim dos métodos privativos */
		

		/* métodos públicos */
		public function AddTabela($_width="100%") {
			$this->_id_tabela = $this->AddTag("TABLE",
											  Array("border"=>0,
							  		    			"cellspacing"=>0,
							  		    			"cellpadding"=>2,
										  			"width"=>$_width,
										  			"valign"=>"top")
						 					 );
		}

		public function setNumCols($_num) {
			$this->_num_cols = $_num;
		}
		
		public function getNumCols() {
			return $this->_num_cols;
		}
		
		public function setCorFundoHeader($_cor) {
			$this->_cor_fundo_header = $_cor;
		}
		
		public function getCorFundoHeader() {
			return $this->_cor_fundo_header;
		}
				
		public function setCorFundoDetalhe($_cor) {
			$this->_cor_fundo_detalhe = $_cor;
		}
		
		public function getCorFundoDetalhe() {
			return $this->_cor_fundo_detalhe;
		}
   
		public function setCorFonteHeader($_cor) {
			$this->_cor_fonte_header = $_cor;
		}
		
		public function getCorFonteHeader() {
			return $this->_cor_fonte_header;
		}

		public function setCorFonteDetalhe($_cor) {
			$this->_cor_fonte_detalhe = $_cor;
		}
		
		public function getCorFonteDetalhe() {
			return $this->_cor_fonte_detalhe;
		}
		
		public function setFonte($_fnt) {
			$this->_fonte = $_fnt;
		}
		
		public function getFonte() {
			return $this->_fonte;
		}
		
		public function setExtras($_extras) {
			$this->_extras = $_extras;
		}
		
		public function getExtras() {
			return $this->_extras;
		}

		public function Addheader($_head) {
			/* _head = Array(Valores para o cabeçalho) */
			if($this->_header===TRUE) {
				return FALSE;
			}
			if($this->_num_cols==0) {
				$this->setNumCols(sizeof($_head));
			} elseif(sizeof($_head)!=$this->_num_cols) {
				return FALSE;
			}
			$this->AddTRTD($_head);
			return TRUE;
		}
		
		public function AddDetalhe($_detalhe) {
			if($this->_num_cols==0) {
				$this->setNumCols(sizeof($_detalhe));
			} elseif($this->_num_cols!=sizeof($_detalhe)) {	
				return FALSE;
			}
			$this->AddTRTD($_detalhe,1);
			return TRUE;
		}
		
		public function AddFooter($_footer,$_colspan=FALSE) {
			if($this->_footer===TRUE) {
				return FALSE;
			}
			if($this->_num_cols!=sizeof($_footer)&&$_colspan===FALSE) {
				return FALSE;
			} 
			$this->AddTRTD($_footer,0,$_colspan);
			return TRUE;
		}
		
		public function close() {
			if($this->_id_tabela===NULL) {
				return FALSE;
			}
			$this->EndTag($this->_id_tabela);
			return TRUE;
		}
   }

?>