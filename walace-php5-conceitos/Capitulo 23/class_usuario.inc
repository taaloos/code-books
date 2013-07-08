	<?php			   
		/* Definição das interfaces */
		require_once("interfaces.inc");
		
		/* Classe usuario */
		class usuario implements ITabela {
			private $_bd = NULL;
			private $_userId = NULL;
			private $_userName;
			private $_userLogin;
			private $_userPassw;
			private $_userEmail;
			private $_userNivel;
			
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
				$_dados = array_change_key_case($this->_bd->getDados(),CASE_LOWER);
				$this->_userId = (int) $_dados["userid"];
				$this->_userName = $_dados["username"];
				$this->_userLogin = $_dados["userlogin"];
				$this->_userPassw = $_dados["userpassw"];
				$this->_userNivel = (int) $_dados["usernivel"];	
				$this->_userEmail = $_dados["useremail"];		
			}
				 
			private function verifica($_campo,$_valor) {
				if($_campo!="userId" && $_campo!="userNivel") {
					$_valor = "'$_valor'";
				}
				$_sql = "SELECT userId FROM usuario WHERE ";
				$_sql.= "$_campo = $_valor";
				$_res = $this->_bd->executa($_sql);
				if($_res===FALSE || $this->_bd->getNumRows()>0) {
					$_dados = array_change_key_case($this->_bd->getDados(),CASE_LOWER);
					return $_dados["userid"];
				}
				return FALSE;			
			}
			
			private function validar($_tipo="I") {
				// validação básica
				if(	$this->_userName=="" || $this->_userLogin=="" ||
					$this->_userEmail=="" || $this->_userPassw=="") {
					return FALSE;
				}
				// Verificar se o Login já Existe
				if(($_res=$this->verifica("userLogin",$this->_userLogin))!==FALSE) {
					if($_tipo=="I" || $this->_userId!=$_res) { 
						return FALSE;
					}
				}
				// verifica se o email Existe
				if(($_res=$this->verifica("userEmail",$this->_userEmail))!==FALSE) {
					if($_tipo=="I" || $this->_userId!=$_res) {
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
			
			public function setUserName($_vlr) {
				$this->_userName = $_vlr;
			}
			
			public function setUserLogin($_vlr) {
				$this->_userLogin = $_vlr;
			}

			public function setUserEmail($_vlr) {
				$this->_userEmail = $_vlr;
			}					 

			public function setUserPassw($_vlr) {
				$this->_userPassw = $_vlr;
			}
			
			public function setUserNivel($_vlr) {
				$this->_userNivel = $_vlr;
			}
			
			public function getUserId() {
			 	return $this->_userId;
			}
			
			public function getUserName() {
			 	return $this->_userName;
			}						   

			public function getUserLogin() {
			 	return $this->_userLogin;
			}
			
			public function getUserPassw() {
			 	return $this->_userPassw;
			}							

			public function getUserNivel() {
			 	return $this->_userNivel;
			}
			
			public function getUserEmail() {
			 	return $this->_userEmail;
			}
			
			public function Buscar($_usuario) {
				$_sql = "SELECT * FROM usuario WHERE ";
				if(is_int($_usuario)) {
					$_sql.= "userId = $_usuario";
				} else {
					$_sql.= "userLogin = '$_usuario'";
				}		
				$this->_bd->setSQL($_sql);
				if($this->_bd->executa()!==FALSE) {	
					if($this->_bd->getNumRows()>0) {
						// Busca os dados do usuário...
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
					// Ok podemos incluir o usuário
					$_sql = "INSERT INTO usuario(";
					$_sql.= "userName,userLogin,userPassw,";
					$_sql.= "userEmail,userNivel) VALUES(";
					$_sql.= "'{$this->_userName}',";
					$_sql.= "'{$this->_userLogin}',";
					$_sql.= "'{$this->_userPassw}',";
					$_sql.= "'{$this->_userEmail}',";
					$_sql.= "{$this->_userNivel})";	  
					return $this->executaSQL($_sql);
				} else {
					return FALSE;
				}
			}
			
			public function Alterar() {
				if($this->_userId===NULL || !$this->validar("A")) {	
					return FALSE; 
				} else {
					// OK...
					$_sql = "UPDATE usuario SET ";
					$_sql.= "userName = '{$this->_userName}',";
					$_sql.= "userPassw = '{$this->_userPassw}',";
					$_sql.= "userEmail = '{$this->_userEmail}',";
					$_sql.= "userNivel = {$this->_userNivel} ";
					$_sql.= "WHERE userId = {$this->_userId}"; 
					return $this->executaSQL($_sql);
				}
			}
			
			public function Excluir() {
				if($this->_userId===NULL || !is_int($this->_userId)) {	 
					return FALSE;
				} else {
				 	$_sql = "DELETE FROM usuario WHERE ";
					$_sql.= "userId = {$this->_userId}";
					return $this->executaSQL($_sql);
				}
			}
			
			public function autentica($_usuario,$_passw) {
				if($this->buscar($_usuario)) {
					if(trim($this->_userPassw)==trim($_passw)) {
						return TRUE;
					} else {				  
						return "Senha informada não confere com a do Uusuário";
					}
				} else {
					return "Usuário Não Cadastrado";
				}
			} 
			
			public function email($_assunto,$_mensagem) {
				$_email = new email();
				$_email->setDestino($this->_userEmail);
				$_email->setAssunto($_assunto);
				$_email->setHeader("Content-Type","text/HTML");
				$_email->setMensagem($_mensagem);
				return $_email->enviar();
			}
			
			
			public function Listar() {
				$_sql = "SELECT userId, userName, userLogin, userNivel, userEmail ";
				$_sql.= "FROM Usuario ORDER BY userLogin";
				$this->_bd->executa($_sql);
				$_html = new TABELA(TRUE,650);
				$_html->setCorFundoHeader("#ece9d8");
				$_html->setCorFonteHeader("black");
				$_html->setExtras("border-bottom: 2px Solid #aca899;");
				$_html->AddHeader(Array("Id","Nome","Login","Nivel","E-mail","Opções"));
				$_html->setExtras("border-bottom: 1px solid #C0C0C0;");
				while(($_dados = $this->_bd->getDados())!==FALSE) {
					// Opção de Alteração e Exclusão de usuários 
					$_dados[] = "<A Href=\"{$_SERVER["PHP_SELF"]}?userid={$_dados["userId"]}&opt=A\">Alterar</A>&nbsp;&nbsp;&nbsp;" . 
								"<A Href=\"{$_SERVER["PHP_SELF"]}?userid={$_dados["userId"]}&opt=E\">Excluir</A>";
					$_html->AddDetalhe($_dados);
				}
				$_html->SetCorFundoHeader("#ffffff");
				$_html->SetCorFonteHeader("brown");
				$_html->SetExtras("font-size: 9px; height: 25;");	
				$_html->AddFooter("Total de {$this->_bd->getNumRows()} Usuários",0,TRUE);
				$_tr = $_html->AddTag("TR");
				$_td = $_html->AddTag("TD",Array("COLSPAN"=>$_html->GetNumCols(),"ALIGN"=>"CENTER","HEIGHT"=>50));
				$_html->AddTag("A",Array("HREF"=>"{$_SERVER["PHP_SELF"]}?opt=I"),TRUE,"Incluir um novo Usuário");
				$_html->EndTag($_td);
				$_html->EndTag($_tr);
				$_html->close(); 
				// Inlcuir um novo usuário....								   
				return $_html->toHTML();
			}
	
		}
	?>
