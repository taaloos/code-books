	<?php
		require_once("class_bd.inc");
		require_once("class_HTML.inc");
		require_once("class_usuario.inc");
		require_once("class_sessao.inc");
		
		/* 
		PostgreSQL 
		$_con = new CONSULTA("postgresql");
		$_con->setUsuario("postgres");
		
		MySQL
		$_con = new CONSULTA();
		*/

		/* MySQLI */
		$_con = new CONSULTA("mysqli");		
		$_con->setBD("BD_PHP5");	
		$_con->conecta();		   			   
		
		$_usr = new USUARIO($_con);

		$_sess = new sessao(TRUE);
		if($_GET["opt"]!="I") {
			if($_POST["opcao"]!="CA"&&$_POST["opcao"]!="CI") {
				if($_sess->getVars("userid")===NULL) {
					$_opcao = "I";
				} else {
					// buscar o Usuário
					$_opcao = "A";
					$_GET["userid"] = $_sess->getVars("userid");
				}
			} else {
				$_opcao = $_POST["opcao"];
			}
		} else {
			$_opcao = "I";
		}
		 
		$_html = new HTML();
		$_id[0] = $_html->AddTag("HTML");
		$_id[1] = $_html->AddTag("HEAD");
		$_html->AddTag("TITLE",NULL,TRUE,"PHP5 - Editora Érica");
		$_html->AddTag("SCRIPT",Array("Language"=>"JavaScript",
									"src"=>"funcoes.js"),TRUE);
		$_html->EndTag($_id[1]);									
		$_id[1] = $_html->AddTag("BODY",Array("width"=>600));
		

				
		switch($_opcao) {
			case 'CA':	// Alteração dos dados		  
						if($_usr->buscar((int) $_POST["userid"])===FALSE) {
							echo "<script>alert('Usuário não Cadastrado');</script>";
							$_opcao = "";
							break;
						}											  
			case 'CI':	// Inlcusão de um novo usuário	
						$_usr->setUserName($_POST["userName"]);
						$_usr->setUserEmail($_POST["userEmail"]);
						if($_opcao=="CI") {
							$_usr->setUserLogin($_POST["userLogin"]);
						}
						$_usr->setUserPassw($_POST["userPassw"]);
						if($_opcao!="CI") {						
							$_usr->setUserNivel($_sess->getVars("userNivel"));
						} else {
							$_usr->setUserNivel(5);
						}
						if($_opcao=="CI") {
							if($_usr->Incluir()===TRUE) {
								echo "<script>alert('Usuário Incluido');</script>";
							} else {
								echo "<script>alert('Ocorreu um Erro na Inclusão');</script>";
								echo "ERRO";
								exit;
								$_opcao = "I";
								break;
							}
						} else {
							if($_usr->Alterar()===TRUE) {
								echo "<script>alert('Usuário Alterado');</script>";
							} else {
								echo "<script>alert('Ocorreu um Erro na Alteração');</script>";	 
								$_GET["userid"] = $_POST["userid"];
								$_opcao = "A";
								break;
							}
						}
						echo "<script>location.href='login.php5';</script>";
						exit;
						break;
		}
		
		switch($_opcao) {
			case 'A':	// Alteração (mesmo formulário de Inclusão)
						if($_usr->buscar((int) $_GET["userid"])===FALSE) {
							echo "<script>alert('Usuário não Cadastrado');</script>";
							$_opcao = "";
							break;
						}											  
			case 'I':	// Incluir um usuário ou alterar seus dados
						$_s = $_html->AddTag("SCRIPT",NULL);
						$_html->AddText($_s,"   var campos = new Array(0,1,2,3" . ($_opcao=="I" ? "4" : "") . ");\n");
						$_html->AddText($_s,"   var nomes  = new Array('Nome','E-mail'," . ($_opcao=="I" ? "Login," : "") . "'Senha','Confirmação de Senha');\n");
						$_html->AddText($_s,"   var tipos  = new Array(8,4," . ($_opcao=="I" ? "9" : "") . "9,10);\n");
						$_html->AddText($_s,"   var status = new Array(1,1,1,1.1);\n");
						$_html->EndTag($_s);
						$_html->AddTag("P",NULL,TRUE,"<b>" . ($_opcao=="I" ? "Inclusão de usuário" : "Alteração dos dados Cadastrais") . "</b>");
						$_f = $_html->AddTag("FORM",Array("name"=>"usuario",
												"method"=>"POST",
												"action"=>$_SERVER["PHP_SELF"],
												"onSubmit"=>"return valida_form(0,campos,nomes,tipos,status);"));
						$_tab = $_html->AddTag("TABLE",Array("border"=>0,
							  		    				"cellspacing"=>0,
							  		    				"cellpadding"=>2,
										  				"width"=>500,
										  				"valign"=>"top"));
						// Nome do usuário
						$_tr = $_html->AddTag("TR");
						$_html->AddTag("TD",NULL,TRUE,"Nome:");
						$_td = $_html->AddTag("TD");						
						$_html->AddTag("INPUT",Array("name"=>"userName",
													"size"=>30,
													"type"=>"text",
													"value"=>$_usr->getUserName()),TRUE);
						$_html->EndTag($_td);
						$_html->EndTag($_tr);
						// Endereço de E-mail
						$_tr = $_html->AddTag("TR");
						$_html->AddTag("TD",NULL,TRUE,"E-mail:");
						$_td = $_html->AddTag("TD");						
						$_html->AddTag("INPUT",Array("name"=>"userEmail",
													"size"=>30,
													"type"=>"text",
													"value"=>$_usr->getUserEmail()),TRUE);
						$_html->EndTag($_td);
						$_html->EndTag($_tr); 
						// Login
						$_tr = $_html->AddTag("TR");
						$_html->AddTag("TD",NULL,TRUE,"Login:");
						$_td = $_html->AddTag("TD");						
						if($_opcao=="A") {
							$_html->AddText($_td,$_usr->getUserLogin());
						} else {
							$_html->AddTag("INPUT",Array("name"=>"userLogin",
														"size"=>20,
														"type"=>"text",
														"value"=>$_usr->getUserLogin()),TRUE);
						}
						$_html->EndTag($_td);
						$_html->EndTag($_tr);
						// Senha
						$_tr = $_html->AddTag("TR");
						$_html->AddTag("TD",NULL,TRUE,"Senha:");
						$_td = $_html->AddTag("TD");						
						$_html->AddTag("INPUT",Array("name"=>"userPassw",
													"size"=>20,
													"type"=>"password",
													"value"=>$_usr->getUserPassw()),TRUE);
						$_html->EndTag($_td);
						$_html->EndTag($_tr);
						// Confirmação da senha
						$_tr = $_html->AddTag("TR");
						$_html->AddTag("TD",NULL,TRUE,"Confirmação de Senha:");
						$_td = $_html->AddTag("TD");						
						$_html->AddTag("INPUT",Array("name"=>"userCPassw",
													"size"=>20,
													"type"=>"password",
													"value"=>$_usr->getUserPassw()),TRUE);
						$_html->EndTag($_td);
						$_html->EndTag($_tr);  
						// Botão OK
						$_tr = $_html->AddTag("TR");
						$_td = $_html->AddTag("TD", Array("colspan"=>2,"align"=>"right"));						
						$_html->AddTag("INPUT",Array("name"=>"ok",
													"type"=>"submit",
													"value"=>"Confirmar"),TRUE);
						$_html->AddTag("INPUT",Array("name"=>"userid",
													"value"=>$_GET["userid"],
													"type"=>"hidden"),TRUE);
						$_html->AddTag("INPUT",Array("name"=>"opcao",
													"value"=>"C" . $_opcao,
													"type"=>"hidden"),TRUE);
						$_html->EndTag($_td);
						$_html->EndTag($_tr);
						$_html->EndTag($_tab);
						$_html->EndTag($_f);
						break;
		}
		
		$_html->EndTag($_id[1]);
		$_html->EndTag($_id[0]);
		echo $_html->toHTML();
		
		$_con->close();
	
	?>