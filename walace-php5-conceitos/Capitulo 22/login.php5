	<?php
		/* Tela de Login de usuários */
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
		
		if(isset($_POST["login"])) {
		 	if($_usr->autentica($_POST["login"],$_POST["senha"])===TRUE) {
				// Ok... direcionar o usuário	  
				$_v = Array("userid"=>$_usr->getUserId(),
							"userName"=>$_usr->getuserName(),
							"userNivel"=>$_usr->getuserNivel());
				$_sess = new sessao(TRUE,$_v);
				if($_usr->getuserNivel()==1) { 
					$_url = "man_usuario.php5";
				} else {
					$_url = "cadastro.php5";
				}
				echo "<script>location.href='$_url';</script>";
			} else {
				echo "<script>alert('Usuário e/ou Senha Inválido');</script>";			
			}
		}

		$_html = new HTML();
		$_id[0] = $_html->AddTag("HTML");
		$_id[1] = $_html->AddTag("HEAD");
		$_html->AddTag("TITLE",NULL,TRUE,"PHP5 - Editora Érica");
		$_html->EndTag($_id[1]);									
		$_id[1] = $_html->AddTag("BODY",Array("width"=>600));
		$_html->AddTag("P",NULL,TRUE,"<b> Autenticação de Usuário</b>");
		$_f = $_html->AddTag("FORM",Array("name"=>"usuario",
								"method"=>"POST",
								"action"=>$_SERVER["PHP_SELF"]));
		$_tab = $_html->AddTag("TABLE",Array("border"=>0,
			  		    				"cellspacing"=>0,
			  		    				"cellpadding"=>2,
						  				"width"=>300,
						  				"valign"=>"top"));
		// Login do usuário
		$_tr = $_html->AddTag("TR");
		$_html->AddTag("TD",NULL,TRUE,"Login:");
		$_td = $_html->AddTag("TD");						
		$_html->AddTag("INPUT",Array("name"=>"login",
									"size"=>20,
									"type"=>"text"),TRUE);
		$_html->EndTag($_td);
		$_html->EndTag($_tr);
		// Senha
		$_tr = $_html->AddTag("TR");
		$_html->AddTag("TD",NULL,TRUE,"Senha:");
		$_td = $_html->AddTag("TD");						
		$_html->AddTag("INPUT",Array("name"=>"senha",
									"size"=>20,
									"type"=>"password"),TRUE);
		$_html->AddTag("SPAN",NULL,TRUE,"&nbsp;&nbsp;");									
		$_html->AddTag("INPUT",Array("name"=>"ok",
									"type"=>"submit",
									"value"=>" OK "),TRUE);
		$_html->EndTag($_td);
		$_html->EndTag($_tr);
		// Link para Cadastr-se
		$_tr = $_html->AddTag("TR");
		$_td = $_html->AddTag("TD", Array("colspan"=>2,"align"=>"center"));						
		$_html->AddTag("A",Array("HREF"=>"cadastro.php5?opt=I"),TRUE,"Cadastre-se");
		$_html->EndTag($_td);
		$_html->EndTag($_tr);
		
		$_html->EndTag($_tab);
		$_html->EndTag($_f);
		$_html->EndTag($_id[1]);
		$_html->EndTag($_id[0]);

		echo $_html->toHTML();
		
		$_con->close();
	?>