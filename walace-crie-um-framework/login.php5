<?php
session_start();	
session_destroy();

include_once("framework/classes/classe_html.inc");
include_once("framework/classes/classe_formulario.inc");

$_tipos = new tipospadrao();
$_main = new tag($_tipos->getTipo("HTML"));
$_main->addSubTag(new tag($_tipos->getTipo("HEAD")));
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TITLE"),null,"Sistema WEB - Autenticação de Usuários"));
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("SCRIPT"),Array(new atributo("SRC","framework/javascript/ajax.js"))));
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("SCRIPT"),Array(new atributo("SRC","framework/javascript/processaajax.js"))));
$_main->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("SCRIPT"),Array(new atributo("SRC","framework/javascript/funcoesgenericas.js"))));
$_main->addSubTag(new tag($_tipos->getTipo("BODY")));
$_main->getLastSubTag()->AddSubTag(new tag($_tipos->getTipo("TABLE"),
											Array(new atributo("ID","TAB_PRINCIPAL"),
												  new atributo("BORDER",0),
												  new atributo("CELLPADDING",0),
												  new atributo("CELLSPACING",0),
												  new atributo("STYLE","position:relative;top:150px;border:1px solid #99ccff;border-collapse:collapse;"),
												  new atributo("ALIGN","CENTER"),
												  new atributo("WIDTH",450))));
$_main->getLastSubTag()->getLastSubTag()->addSubtag(new tag($_tipos->getTipo("TR")));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubtag(new tag($_tipos->getTipo("TD"),
											Array(new atributo("STYLE","padding:5px"),
												  new atributo("ALIGN","CENTER"))));
// Tabela para Login
$_tablogin = new tag($_tipos->getTipo("TABLE"),
					Array(new atributo("BORDER",0),
						  new atributo("CELLPADDING",0),
						  new atributo("CELLSPACING",0),
						  new atributo("STYLE","border-collapse:collapse;"),
						  new atributo("ALIGN","CENTER"),
						  new atributo("WIDTH",450)));	  	
$_tablogin->addSubTag(new tag($_tipos->getTipo("TR")));
$_tablogin->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
											   Array(new atributo("STYLE","background-color:#ecf5ff;color:#ff9900;text-align:right;padding:5px;font-size:12px;font-family:Verdana;"),
											   		 new atributo("COLSPAN",2)),"Autenticação de Usuários"));
$_tablogin->addSubTag(new tag($_tipos->getTipo("TR")));
$_tablogin->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
											   Array(new atributo("STYLE","height:15px;background-color:#ecf5ff;"),
											   		 new atributo("COLSPAN",2)),"&nbsp;"));
$_tablogin->addSubTag(new tag($_tipos->getTipo("TR")));
$_tablogin->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
											   Array(new atributo("STYLE","background-color:#ecf5ff;width:180px;text-align:center;"))));
$_tablogin->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("IMG"),
																Array(new atributo("SRC","framework/imagens/logo_login.png"),
																	  new atributo("BORDER",0),
																	  new atributo("STYLE","position:relative;top:-30px;"))));
$_tablogin->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
											   Array(new atributo("STYLE","background-color:#ecf5ff;text-align:center"))));
// Formulário de Autenticação
$_form = new formulario("LOGIN","index.php5");
$_form->addSubTag(new tag($_tipos->getTipo("TABLE"),
					Array(new atributo("BORDER",0),
						  new atributo("CELLPADDING",0),
						  new atributo("CELLSPACING",0))));
$_form->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TR")));
$_form->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
											   				Array(new atributo("STYLE","width:190px;border:1px solid #d0d0d0;border-bottom:0px none;height:5px;font-size:1px"),
											   		 			  new atributo("COLSPAN",2)),"&nbsp;"));
// Usuario
$_form->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TR")));
$_form->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
											   				Array(new atributo("STYLE","color:#0066cc;padding-left:5px;padding-top:5px;font-size:12px;")),
											   				"Usuário"));
$_form->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
											   				Array(new atributo("STYLE","padding-left:10px;padding-right:5px;padding-top:5px;"))));
$_usr = new formInputTexto("USUARIO",'STR',25,20);
$_usr->setValidaCampo('STR','USUARIO','Usuário',5);
$_usr->addAtributo(new atributo("STYLE","border:1px solid #3399cc;color:Navy;padding-left:3px;"));
$_form->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag($_usr);

$_form->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TR")));
$_form->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
											   				Array(new atributo("STYLE","height:10px;font-size:1px"),
											   		 			  new atributo("COLSPAN",2)),"&nbsp;"));
// Senha
$_form->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TR")));
$_form->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
											   				Array(new atributo("STYLE","color:#0066cc;padding-left:5px;padding-bottom:5px;font-size:12px;")),
											   				"Senha"));
$_form->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
											   				Array(new atributo("STYLE","padding-left:10px;padding-right:5px;padding-bottom:5px;"))));
$_snh = new formInputPassword("SENHA",15,15);
$_snh->setValidaCampo('STR','SENHA','Senha',4);
$_snh->addAtributo(new atributo("STYLE","border:1px solid #3399cc;color:Navy;padding-left:3px;"));
$_form->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag($_snh);
$_form->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("A"),
																			 Array(new atributo("HREF","javascript:void(0);"),
																			 	   new atributo("STYLE","color:#ff9900;font-size:10px;font-family:Verdana;"),
																			 	   new atributo("ONCLICK",
																			 	   "document.getElementById('REC_SENHA').style.visibility='visible';" . 
																			 	   "document.getElementById('ID_USUARIO').focus();")),"Esqueceu?"));
$_form->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TR")));
$_form->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
											   				Array(new atributo("STYLE","width:190px;border:1px solid #d0d0d0;border-top:0px none;height:5px;font-size:1px"),
											   		 			  new atributo("COLSPAN",2)),"&nbsp;"));
// Enviar
$_form->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TR")));
$_form->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
											   				Array(new atributo("STYLE","padding-top:15px;text-align:center"),
											   					  new atributo("COLSPAN",2))));
$_env = new formInputSubmit("OK"," Entrar ");
$_env->addAtributo(new atributo("STYLE","border:1px Solid #4682b4;width:90px;padding:4px;padding-left:25px;color:Navy;background: url(framework/imagens/user_btn.png) 5px center no-repeat;"));
$_form->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag($_env);
$_tablogin->getLastSubTag()->getLastSubTag()->addSubTag($_form);
$_tablogin->addSubTag(new tag($_tipos->getTipo("TR")));
$_tablogin->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
											   Array(new atributo("STYLE","height:15px;background-color:#ecf5ff;"),
											   		 new atributo("COLSPAN",2)),"&nbsp;"));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubtag($_tablogin);
// Tabela para Recuperar Senha
$_frec = new formulario("LOGIN","javascript:void(0);");
$_frec->deleteAtributo(4);
$_frec->addAtributo(new atributo("ONSUBMIT",
					"document.getElementById('REC_RESP').innerHTML='<img src=\\'framework/imagens/spinner.gif\\' border=0> Aguarde...';" . 
					"ObjProcAjax.run('recupera_senha.php5?usuario='+document.getElementById('ID_USUARIO').value,'REC_RESP');return false;"));
$_frec->addSubTag(new tag($_tipos->getTipo("TABLE"),
					Array(new atributo("ID","REC_SENHA"),
						  new atributo("BORDER",0),
						  new atributo("CELLPADDING",0),
						  new atributo("CELLSPACING",0),
						  new atributo("STYLE","position:relative;top:180px;border-collapse:collapse;visibility:hidden;"),
						  new atributo("ALIGN","CENTER"))));
$_frec->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TR")));
$_frec->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
											   				Array(new atributo("STYLE","font-size:11px;color:#888888;")),
											   				"Usuário ou E-mail"));
$_frec->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
											   				Array(new atributo("STYLE","padding-left:5px;"))));
$_usr = new formInputTexto("ID_USUARIO",'STR',30,20);
$_usr->addAtributo(new atributo("STYLE","font-size:10px;border:1px solid #c0c0c0;color:#777777;"));
$_frec->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag($_usr);
$_frec->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
											   				Array(new atributo("STYLE","padding-left:5px;"))));
$_env = new formInputSubmit("REC"," Recpuerar Senha ");
$_env->addAtributo(new atributo("STYLE","border:1px solid #c0c0c0;background-color:#f0f0f0;font-size:10px;color:#777777"));
$_frec->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag($_env);
$_frec->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TR")));
$_frec->getLastSubTag()->getLastSubTag()->addSubTag(new tag($_tipos->getTipo("TD"),
											   				Array(new atributo("ID","REC_RESP"),
											   					  new atributo("COLSPAN",3),
											   					  new atributo("STYLE","font-size:11px;color:#3399ff;padding-top:10px;width:300px;"))));
$_main->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubtag($_frec);
echo $_main->toHTML(false);
?>