<?php
	require_once("class_bd.inc");
	
	// Conecta o banco de dados MySQL
	$_con = new consulta("mysqli");
	$_con->setBD("BD_PHP5");
	$_con->setUsuario("root");
	$_con->setSenha("");
	$_con->conecta();
	if($_con===FALSE||$_con->getConnection()===NULL) {
		echo "Erro na Conexão com o Banco de dados...";
		exit;
	} 
	

	// Mopstra os dados da conexão	
	echo "<pre>";
	print_r($_con->printBD()); 
	echo "</pre>";
	
	// Executa uma consulta simples
	$_con->setSQL("SELECT * FROM usuario");
	$_con->setTipo(1);  // Determina que o resultado será um objeto
	
	if($_con->executa()===FALSE) {
		echo "Erro na execução do comando " . $_con->getSQL(); 
		exit;
	}
	
	// Número de linhas retornadas na consulta
	echo "A consulta retornou {$_con->getNumRows()} Linhas<br/>";
	
	// Mostra a primeira linha do resultado
	echo "<pre>";
	print_r($_con->getDados());
	echo "</pre>";
	
	// Mostra a próxima linha do resultado	
	echo "<pre>";
	print_r($_con->getDados());
	echo "</pre>";
	
	// Busca a ultima linha do resultado
	$_con->ultimo();
	echo "<pre>";
	print_r($_con->getDados());
	echo "</pre>"; 
	
	$_con->primeiro();
	$_con->proximo();
	$_con->anterior();
	echo "Registro Atual: " . $_con->getAtual() . "<br/>";
	echo "<pre>";
	print_r($_con->getDados());
	echo "</pre>"; 
	
	$_con->navega(3);
	echo "Registro Atual: " . $_con->getAtual() . "<br/>";
	echo "<pre>";
	print_r($_con->getDados());
	echo "</pre>"; 
	
	
	// Fecha a conexão	
	$_con->close();
?>
 