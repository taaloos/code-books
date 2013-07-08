<?php
/**
 * Autenticação de Usuario e Controle de sessão
 */

session_start();

if($_SESSION['USUARIO_AUTENTICADO']===true) {
	return true; // O usuário está Ok, podemos continuar..
} else {
	// Validar o usuario
	if(empty($_POST['USUARIO'])||empty($_POST['SENHA'])) {
		die("<html><body><script>alert('Favor informar o usuário e a Senha');document.location.href='login.php5';</script></body></html>");
	} else {
		$_usuario = new usuario($_bd);
		if(($_res=$_usuario->login($_POST['USUARIO'],$_POST['SENHA']))===true) {
			// Vamos registra-lo
			$_SESSION['USUARIO_AUTENTICADO'] = true;
			$_SESSION['USUARIO_ID'] 	= $_usuario->getCampo('USUARIO_ID')->getValor();
			$_SESSION['USUARIO_LOGIN'] 	= $_usuario->getCampo('USUARIO_LOGIN')->getValor();
			$_SESSION['USUARIO_NOME'] 	= $_usuario->getCampo('USUARIO_NOME')->getValor();
			$_SESSION['USUARIO_EMAIL'] 	= $_usuario->getCampo('USUARIO_EMAIL')->getValor();
			// Menus e Permissões
			$_perm = new permissao($_bd);
			$_menu = new menu($_bd);
			$_autorizados = Array();
			$_SESSION['MENU'] = serialize($_menu->geraMenuHTML($_perm->retornaPermissoes($_usuario->getCampo('USUARIO_ID')->getValor()),$_autorizados));
			$_SESSION['AUTORIZADOS'] = serialize($_autorizados);
			return true;
		} else {
			die("<html><body><script>alert('{$_res}');document.location.href='login.php5';</script></body></html>");
		}
	}
}

?>