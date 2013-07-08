	<?php
		require_once("class_bd.inc");
		require_once("class_HTML.inc");
		require_once("class_usuario.inc");
		require_once("class_sessao.inc"); 
		require_once("class_permissao.inc");
		
		
		$_script = "man_permissao.php5";
		
		 
		/*PostgreSQL 
		$_con = new CONSULTA("postgresql");
		$_con->setUsuario("postgres");
		*/
		/*
		MySQL
		$_con = new CONSULTA();
		*/

		/* MySQLI */
		$_con = new CONSULTA("mysqli");
		$_con->setBD("BD_PHP5");		   
		$_con->conecta();
		
		$_usr = new USUARIO($_con);

		/* Primeramente verifica se uma sessão foi aberta */
		$_sess = new sessao(TRUE);
		if($_sess->getVars("userid")===NULL) {
			// Usuário não autorizado		  
			echo "<script>location.href='login.php5';</script>";
			exit;
		}
		
		/* Verificar se o usuário tem permissão para acessar esta página */
		$_p = new permissao($_con);
		if($_p->permissao($_script,$_sess->getVars("userNivel"))===FALSE) {
			echo "<p><b>Você não tem permissão para acessar esta página...</b></p>";
			exit;
		}	  
		
		$_perm = new Permissao($_con);
		
		// OK
		
		$_html = new HTML();
		$_id[0] = $_html->AddTag("HTML");
		$_id[1] = $_html->AddTag("HEAD");
		$_html->AddTag("TITLE",NULL,TRUE,"PHP5 - Editora Érica - Manutenção de Permissões");
		$_html->AddTag("SCRIPT",Array("Language"=>"JavaScript",
									"src"=>"funcoes.js"),TRUE);
		$_html->EndTag($_id[1]);									
		$_id[1] = $_html->AddTag("BODY",Array("width"=>600));
		
		// Opção escolhida pelo Usuário (I,A ou E) ou (CA, CI ou CE)
		if(isset($_GET["opt"])) {
			$_opcao = $_GET["opt"];
		} elseif(isset($_POST["opcao"])) {
			$_opcao =  $_POST["opcao"];  
		}
				
		switch($_opcao) {
			case 'CA':	// Alteração
						if($_perm->buscar((int) $_POST["permid"])===FALSE) {
							echo "<script>alert('Pemissão não Cadastrada');</script>";
							$_opcao = "";
							break;
						}											  
			case 'CI':	// Inlcusão
						$_perm->setpermDesc($_POST["permDesc"]);
						$_perm->setpermNivel($_POST["permNivel"]);						
						$_perm->setpermScript($_POST["permScript"]);
						if($_opcao=="CI") {
							if($_perm->Incluir()===TRUE) {
								echo "<script>alert('Permissão Incluida');</script>";
							} else {
								echo "<script>alert('Ocorreu um Erro na Inclusão');</script>";
								echo "ERRO";
								exit;
								$_opcao = "I";
								break;
							}
						} else {
							if($_perm->Alterar()===TRUE) {
								echo "<script>alert('Permissão Alterada');</script>";
							} else {
								echo "<script>alert('Ocorreu um Erro na Alteração');</script>";	 
								$_GET["permid"] = $_POST["permid"];
								$_opcao = "A";
								break;
							}
						}
						$_opcao = "";
						break;
			case 'CE':	// Exclusão
						if($_perm->buscar((int) $_POST["permid"])===FALSE) {
							echo "<script>alert('Permissão não Cadastrada');</script>";
							$_opcao = "";
							break;
						}											  
						if($_perm->excluir()===TRUE) {
							echo "<script>alert('Permissão Excluida');</script>";
						} else {
							echo "<script>alert('Ocorreu um Erro na Exclusão');</script>";
						}
						$_opcao = "";
						break;
		}
		

		/* Montar tabela com menu do lado esquerdo */
		$_tab_pr = $_html->AddTag("TABLE",Array("border"=>0,
							  		   		"cellspacing"=>0,
							  		   		"cellpadding"=>2,
											"width"=>800,
											"valign"=>"top"));
		$_tr_pr = $_html->AddTag("TR");
		$_html->AddTag("TD",Array("valign"=>"top"),TRUE,$_p->menu($_sess->getVars("userNivel")));
		$_td_pr = $_html->AddTag("TD",NULL);


		switch($_opcao) {
			case 'A':	// Alteração (mesmo formulário de Inclusão)
						if($_perm->buscar((int) $_GET["permid"])===FALSE) {
							echo "<script>alert('Permissão não Cadastrada');</script>";
							$_opcao = "";
							break;
						}											  
			case 'I':	// Incluir ou alterar
						$_s = $_html->AddTag("SCRIPT",NULL);
						$_html->AddText($_s,"   var campos = new Array(0,1);\n");
						$_html->AddText($_s,"   var nomes  = new Array('Descrição','Script');\n");
						$_html->AddText($_s,"   var tipos  = new Array(8,8);\n");
						$_html->AddText($_s,"   var status = new Array(1,1);\n");
						$_html->EndTag($_s);
						$_html->AddTag("P",NULL,TRUE,"<b>" . ($_opcao=="I" ? "Inclusão de Permissão" : "Alteração dos dados de uma Permissão") . "</b>");
						$_f = $_html->AddTag("FORM",Array("name"=>"permissao",
												"method"=>"POST",
												"action"=>$_SERVER["PHP_SELF"],
												"onSubmit"=>"return valida_form(0,campos,nomes,tipos,status);"));
						$_tab = $_html->AddTag("TABLE",Array("border"=>0,
							  		    				"cellspacing"=>0,
							  		    				"cellpadding"=>2,
										  				"width"=>500,
										  				"valign"=>"top"));
						// Descrição
						$_tr = $_html->AddTag("TR");
						$_html->AddTag("TD",NULL,TRUE,"Descrição:");
						$_td = $_html->AddTag("TD");						
						$_html->AddTag("INPUT",Array("name"=>"permDesc",
													"size"=>30,
													"type"=>"text",
													"value"=>$_perm->getpermDesc()),TRUE);
						$_html->EndTag($_td);
						$_html->EndTag($_tr);
						// Script
						$_tr = $_html->AddTag("TR");
						$_html->AddTag("TD",NULL,TRUE,"Nome do Script:");
						$_td = $_html->AddTag("TD");						
						$_html->AddTag("INPUT",Array("name"=>"permScript",
													"size"=>30,
													"type"=>"text",
													"value"=>$_perm->getpermScript()),TRUE);
						$_html->EndTag($_td);
						$_html->EndTag($_tr); 
						// Nivel
						$_tr = $_html->AddTag("TR");
						$_html->AddTag("TD",NULL,TRUE,"Nível do Usuário:");
						$_td = $_html->AddTag("TD");						
						$_sel = $_html->AddTag("SELECT",Array("name"=>"permNivel"));
						$_html->AddTag("OPTION",Array("value"=>1,"_"=>($_perm->getpermNivel()==1 ? "SELECTED" : "")),TRUE,"Adiministrador");
						$_html->AddTag("OPTION",Array("value"=>5,"_"=>($_perm->getpermNivel()==5 ? "SELECTED" : "")),TRUE,"Usuário");
						$_html->EndTag($_sel);
						$_html->EndTag($_td);
						$_html->EndTag($_tr); 
						// Botão OK
						$_tr = $_html->AddTag("TR");
						$_td = $_html->AddTag("TD", Array("colspan"=>2,"align"=>"right"));						
						$_html->AddTag("INPUT",Array("name"=>"ok",
													"type"=>"submit",
													"value"=>"Confirmar"),TRUE);
						$_html->AddTag("INPUT",Array("name"=>"permid",
													"value"=>$_GET["permid"],
													"type"=>"hidden"),TRUE);
						$_html->AddTag("INPUT",Array("name"=>"opcao",
													"value"=>"C" . $_opcao,
													"type"=>"hidden"),TRUE);
						$_html->EndTag($_td);
						$_html->EndTag($_tr);
						$_html->EndTag($_tab);
						$_html->EndTag($_f);
						break;
			case 'E':	// Confirmar Exclusão 
						if($_perm->buscar((int) $_GET["permid"])===FALSE) {
							echo "<script>alert('Permissão não Cadastrada');</script>";
							$_opcao = "";
							break;
						}											  
						$_html->AddTag("P",NULL,TRUE,"<b>Exclusão de Permissão</b>");
						$_f = $_html->AddTag("FORM",Array("name"=>"permissao",
												"method"=>"POST",
												"action"=>$_SERVER["PHP_SELF"]));
						$_tab = $_html->AddTag("TABLE",Array("border"=>0,
							  		    				"cellspacing"=>0,
							  		    				"cellpadding"=>2,
										  				"width"=>500,
										  				"valign"=>"top"));
						// Descrião
						$_tr = $_html->AddTag("TR");
						$_html->AddTag("TD",NULL,TRUE,"Descrição:");
						$_td = $_html->AddTag("TD",NULL,TRUE,$_perm->getpermDesc());						
						$_html->EndTag($_tr);
						// Nome do Script
						$_tr = $_html->AddTag("TR");
						$_html->AddTag("TD",NULL,TRUE,"Script:");
						$_td = $_html->AddTag("TD",NULL,TRUE,$_perm->getpermScript());						
						$_html->EndTag($_tr);
						// Nivel
						$_tr = $_html->AddTag("TR");
						$_html->AddTag("TD",NULL,TRUE,"Nível:");
						$_td = $_html->AddTag("TD",NULL,TRUE,$_perm->getpermNivel());						
						$_html->EndTag($_tr);
						// Botão OK
						$_tr = $_html->AddTag("TR");
						$_td = $_html->AddTag("TD", Array("colspan"=>2,"align"=>"right"));						
						$_html->AddTag("INPUT",Array("name"=>"ok",
													"type"=>"submit",
													"value"=>"Confirmar Exclusão"),TRUE);
						$_html->AddTag("INPUT",Array("name"=>"permid",
													"value"=>$_GET["permid"],
													"type"=>"hidden"),TRUE);
						$_html->AddTag("INPUT",Array("name"=>"opcao",
													"value"=>"CE",
													"type"=>"hidden"),TRUE);
						$_html->EndTag($_td);
						$_html->EndTag($_tr);
						$_html->EndTag($_tab);
						$_html->EndTag($_f);
						break;
			default:
						$_html->addText($_td_pr,$_perm->listar());
		}
		
		$_html->EndTag($_td_pr);
		$_html->EndTag($_tr_pr);
		$_html->EndTag($_tab_pr);
		$_html->AddTag("P",NULL,TRUE,"[{$_sess->getVars("userName")}]");
		$_html->EndTag($_id[1]);
		$_html->EndTag($_id[0]);
		echo $_html->toHTML();
		
		$_con->close();													   
	
	?>