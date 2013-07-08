	<?php			   
		/* Definição das interfaces */
		require_once("interfaces.inc");
		
		/* Classe Permissao */
		class Permissao implements ITabela {
			private $_bd = NULL;
			private $_permId = NULL;
			private $_permDesc;
			private $_permNivel;
			private $_permScript;
			
			/* Construtor da classe */
			function __construct($_bd) {
				if($_bd===NULL) {
					return FALSE;
				} else {
					$this->_bd = $_bd;
					return TRUE;
				}
			}	
			
			private function preenche() { 
				$_dados = $this->_bd->getDados();
				if($_dados===FALSE) {
					return FALSE;
				}
				$_dados = array_change_key_case($_dados,CASE_LOWER);
				$this->_permId = (int) $_dados["permid"];
				$this->_permDesc = $_dados["permdesc"];
				$this->_permNivel = (int) $_dados["permnivel"];
				$this->_permScript = $_dados["permscript"];
				return TRUE;
			}
				 
			private function verifica($_campo,$_valor) {
				if($_campo!="permId" && $_campo!="permNivel") {
					$_valor = "'$_valor'";
				}
				$_sql = "SELECT permId FROM permissao WHERE ";
				$_sql.= "$_campo = $_valor";
				$_res = $this->_bd->executa($_sql);
				if($_res===FALSE || $this->_bd->getNumRows()>0) {
					$_dados = array_change_key_case($this->_bd->getDados(),CASE_LOWER);
					return $_dados["permid"];
				}
				return FALSE;			
			}
			
			private function validar($_tipo="I") {
				// validação básica
				if(	$this->_permDesc=="" || $this->_permScript=="") {
					return FALSE;
				}
				// Verificar se o Script já existe
				if(($_res=$this->verifica("permScript",$this->_permScript))!==FALSE) {
					if($_tipo=="I" || $this->_permId!=$_res) { 
						return FALSE;
					}
				}
				return TRUE; // OK
			}
			
			private function executaSQL($_sql) {
				$this->_bd->setSQL($_sql);
				$_r = $this->_bd->executa();
				if($_r===FALSE || $this->_bd->getAffectedRows()!=1) {
					return FALSE;
				} else {
					return TRUE;
				}				
			}
			
			public function setpermDesc($_vlr) {
				$this->_permDesc = $_vlr;
			}
			
			public function setpermNivel($_vlr) {
				$this->_permNivel = $_vlr;
			}

			public function setpermScript($_vlr) {
				$this->_permScript = $_vlr;
			}					 

			
			public function getpermId() {
			 	return $this->_permId;
			}
			
			public function getpermDesc() {
			 	return $this->_permDesc;
			}						   

			public function getpermScript() {
			 	return $this->_permScript;
			}
			
			public function getpermNivel() {
			 	return $this->_permNivel;
			}
			
			
			public function Buscar($_valor) {
				$_sql = "SELECT * FROM Permissao WHERE ";
				if(is_int($_valor)) {
					$_sql.= "permId = $_valor";
				} else {
					$_sql.= "permScript = '$_valor'";
				}	
				$this->_bd->setSQL($_sql);
				if($this->_bd->executa()!==FALSE) {		
					if($this->_bd->getNumRows()>0) {
						$this->preenche();					  
						return TRUE;
					} else {
						return FALSE;
					}
				} else {
					return FALSE;
				}
			}
			
			public function Incluir() {
				if($this->validar()) {
					$_sql = "INSERT INTO Permissao(";
					$_sql.= "permDesc,permNivel,permScript";
					$_sql.= ") VALUES(";
					$_sql.= "'{$this->_permDesc}',";
					$_sql.= "{$this->_permNivel},";
					$_sql.= "'{$this->_permScript}'";
					$_sql.= ")";	  
					return $this->executaSQL($_sql);
				} else {
					return FALSE;
				}
			}
			
			public function Alterar() {
				if($this->_permId===NULL || !$this->validar("A")) {	
					return FALSE; 
				} else {
					// OK...
					$_sql = "UPDATE Permissao SET ";
					$_sql.= "permDesc = '{$this->_permDesc}',";
					$_sql.= "permScript = '{$this->_permScript}',";
					$_sql.= "permNivel = {$this->_permNivel} ";
					$_sql.= "WHERE permId = {$this->_permId}"; 	
					return $this->executaSQL($_sql);
				}
			}
			
			public function Excluir() {
				if($this->_permId===NULL || !is_int($this->_permId)) {	 
					return FALSE;
				} else {
				 	$_sql = "DELETE FROM Permissao WHERE ";
					$_sql.= "permId = {$this->_permId}";
					return $this->executaSQL($_sql);
				}
			}
			
			
			public function Listar() {
				$_sql = "SELECT * ";
				$_sql.= "FROM Permissao ORDER BY permNivel";
				$this->_bd->executa($_sql);
				$_html = new TABELA(TRUE,650);
				$_html->setCorFundoHeader("#ece9d8");
				$_html->setCorFonteHeader("black");
				$_html->setExtras("border-bottom: 2px Solid #aca899;");
				$_html->AddHeader(Array("Id","Descrição","Nível","Script","Opções"));
				$_html->setExtras("border-bottom: 1px solid #C0C0C0;");
				while(($_dados = $this->preenche())!==FALSE) {
					// Opção de Alteração e Exclusão de usuários 
					$_det[0] = $this->_permId;
					$_det[1] = $this->_permDesc;
					$_det[2] = $this->_permNivel;
					$_det[3] = $this->_permScript;
					$_det[4] = "<A Href=\"{$_SERVER["PHP_SELF"]}?permid={$this->_permId}&opt=A\">Alterar</A>&nbsp;&nbsp;&nbsp;" . 
								"<A Href=\"{$_SERVER["PHP_SELF"]}?permid={$this->_permId}&opt=E\">Excluir</A>";
					$_html->AddDetalhe($_det);
				}
				$_html->SetCorFundoHeader("#ffffff");
				$_html->SetCorFonteHeader("brown");
				$_html->SetExtras("font-size: 9px; height: 25;");	
				$_html->AddFooter("Total de {$this->_bd->getNumRows()} Itens",0,TRUE);
				$_tr = $_html->AddTag("TR");
				$_td = $_html->AddTag("TD",Array("COLSPAN"=>$_html->GetNumCols(),"ALIGN"=>"CENTER","HEIGHT"=>50));
				$_html->AddTag("A",Array("HREF"=>"{$_SERVER["PHP_SELF"]}?opt=I"),TRUE,"Incluir um novo Item de menu");
				$_html->EndTag($_td);
				$_html->EndTag($_tr);
				$_html->close(); 
				// Inlcuir um novo usuário....								   
				return $_html->toHTML();
			}
			
			public function menu($_nivel) {
				// Lista os itens de menu com a permissão indicada (nivel <=)
				$_sql = "SELECT * FROM Permissao WHERE ";
				$_sql.= "permNivel >= $_nivel ORDER By permDesc";	
				$this->_bd->executa($_sql);
				$_html = new TABELA(TRUE,250);
				$_html->setCorFundoHeader("#ece9d8");
				$_html->setCorFonteHeader("black");
				$_html->setExtras("border-bottom: 2px Solid #aca899;");
				$_html->AddHeader(Array("MENU"));
				$_html->setExtras("border-bottom: 1px solid #C0C0C0;background-color:#f4f3ea;");
				while(($_dados = $this->preenche())!==FALSE) {	
					$_menu[0] = "<A style=\"text-decoration: none;\" href=\"{$this->_permScript}\">";
					$_menu[0].= $this->_permDesc . "</A>";
					$_html->AddDetalhe($_menu);
				}
				$_html->close(); 
				return $_html->toHTML();
			}
			
			public function permissao($_script,$_nivel) {
				if($this->Buscar($_script)===TRUE) {
					if($this->_permNivel>=$_nivel) {
						return TRUE;				
					}
				} 
				return FALSE;
			}
	
		}
	?>
