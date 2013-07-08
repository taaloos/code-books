	<?php
  		/* index.php5 */
		$_script = "index.php5";

		require_once("class_bd.inc");
		require_once("class_HTML.inc");
		require_once("class_usuario.inc");
		require_once("class_sessao.inc");
		require_once("class_permissao.inc");
		
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

		if($_sess->getVars("userid")===NULL) {
			echo "<script>location.href='login.php5';</script>";
			exit;
		}
		
		// Listar as opçoes de menu
		$_perm = new Permissao($_con);	
		$_lst = $_perm->menu($_sess->getVars("userNivel"));
		 

		$_html = new HTML();
		$_id[0] = $_html->AddTag("HTML");
		$_id[1] = $_html->AddTag("HEAD");
		$_html->AddTag("TITLE",NULL,TRUE,"PHP5 - Editora Érica");
		$_html->EndTag($_id[1]);									
		$_id[1] = $_html->AddTag("BODY",Array("width"=>800));
		$_html->AddTag("DIV",NULL,TRUE,$_lst);
		
		$_html->EndTag($_id[1]);
		$_html->Endtag($_id[0]);
		
		echo $_html->toHTML();
		
		$_con->close();  
	?>