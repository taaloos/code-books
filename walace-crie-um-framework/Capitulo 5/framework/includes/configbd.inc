<?php
/**
 * Configurador para acesso ao Banco de Dados
 * Altere os valores de $_servidor, $_banco, $_usuario, $_senha e $_porta
 * 
 */

/**
 * @var string define o tipo do banco de dados, padrão pgsql (opção atual mysql)
 */
$_tipobd = 'pgsql';
/**
 * @var string define o endereço do servidor do banco de dados
 */
$_servidor = "localhost";
/**
 * @var integer Porta de conexão
 */
$_portqa = 5432;
/**
 * @var string define o nome do banco de dados que desejamos conectar
 */
$_banco = "siteweb";
/**
 * @var string informa o nome do usuário
 */
$_usuario = "postgres";
/**
 * @var string Senha do usuário
 */
$_senha = "postgres";

/**
 * Conecta com o Banco de dados e retorna uma instancia de bancodados
 */
$_bd = new $_tipobd();
$_bd->SetServidor($_servidor);
$_bd->SetPorta($_porta);
$_bd->SetBanco($_banco);
$_bd->SetUsuario($_usuario);
$_bd->SetSenha($_senha);
if($_bd->Conectar()===false) {
	die("<p style='color:red;font-weight:bold;text-align:center;'>Erro na conexão com o Banco de Dados {$_bd->getUltimoErro()}</p>");
}
?>
