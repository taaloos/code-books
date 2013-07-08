<?php
/**
 * Classe Permissao
 * Gerenciamento de permissões do sistema
 */
class permissao extends BASE {
	public function __construct(BancoDados $_conn) {
		parent::__construct($_conn);
		$this->_nome_tabela = 'permissao';
		$this->addCampo(new inteiro("USUARIO_ID","Código do Usuário",10,null,null,true,false,true,null,null,null,true));
		$this->addCampo(new inteiro("MENU_ID","Código do Menu",10,null,null,true,false,true,null,null,null,true));
		$this->addCampo(new string("PERMISSAO_MODO","Modo (NEG/AUT)",3,null,null,true,true,true,null,null,null,false,$_conn));
	}

	protected function listausuarios() {
		$_usr = new usuario($this->_conn);
		return $_usr->listaUsuarios();
	}
	
	public function geraTelaUsuarios() {
		$_form = new formulario("USUARIOS","javascript:void(0);");
		$_form->deleteAtributo(4);
		$_form->addAtributo(new atributo("ONSUBMIT","document.getElementById('PERMISSOES').innerHTML=" . 
										 "'<img src=\\'framework/imagens/spinner.gif\\' border=0> Aguarde...';" . 
										 "ObjProcAjax.runPost('executa_busca_ajax.php5','PERMISSOES'," . 
										 "'usuario='+document.getElementById('USUARIO_ID').value+" . 
										 "'&classe=permissao&arquivo_classe=framework/classes/classe_permissao.inc" .
										 "&classe_auxiliar=framework/classes/classe_menu.inc" .  
										 "&metodo=geraPermissoes');return false;"));
		$_form->addSubTag(new tag(new tipotag("TABLE"),
							Array(new atributo("BORDER",0),
								  new atributo("CELLPADDING",0),
								  new atributo("CELLSPACING",0),
								  new atributo("VALIGN","TOP"),
								  new atributo("ALIGN","CENTER"))));
		$_form->getLastSubTag()->addSubTag(new tag(new tipotag("TR")));
		$_form->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
													   				Array(new atributo("STYLE","color:Navy;")),"Selecione o usuário:"));
		$_form->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
													   				Array(new atributo("STYLE","padding-left:5px;"))));
		
		$_usr = new formSelect("USUARIO_ID",false,$this->listausuarios());
		$_form->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag($_usr);
		$_form->getLastSubTag()->addSubTag(new tag(new tipotag("TR")));
		$_form->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("TD")));
		$_form->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),Array(new atributo("STYLE","padding-top:15px;"))));
		$_env = new formInputSubmit("Ok"," Busca Permissões ");
		$_form->getLastSubTag()->getLastSubTag()->getLastSubTag()->addSubTag($_env);
		return $_form->toHTML(false);		
	}
	
	/**
	 * Gera sempre a tela de busca de usuários
	 *
	 */
	public function processaAcao() {
		$_comandos  = "document.getElementById('TITULO').innerHTML='{$GLOBALS['_FTitulo']}';";
		$_comandos .= "ObjInfoPagina.classeAtual='" . get_class($this) . "';";
		$_comandos .= "ObjInfoPagina.arquivoClasse='{$this->_class_path}/classes/classe_" . get_class($this) . ".inc';";
		$_comandos .= "ObjInfoPagina.programaAtual='{$_SERVER['PHP_SELF']}';";
		$_sct    = new tag(new tipotag("SCRIPT"),null,$_comandos);
		$_tab = new tag(new tipotag("TABLE"),
							Array(new atributo("BORDER",0),
								  new atributo("CELLPADDING",0),
								  new atributo("CELLSPACING",0),
								  new atributo("VALIGN","TOP"),
								  new atributo("STYLE","padding-top:10px;border:1px solid #c0c0c0;border-collapse:collapse;")));
		$_tab->addSubTag(new tag(new tipotag("TR")));
		$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
							Array(new atributo("STYLE","width:512px;background-color:#ece9d8;color:black;border:1px solid #c0c0c0;text-align:center")),
							"Usuários"));
			
		$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
							Array(new atributo("STYLE","width:512px;background-color:#ece9d8;color:black;border:1px solid #c0c0c0;text-align:center")),
							"Permissões"));
		$_tab->addSubTag(new tag(new tipotag("TR")));
		$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
							Array(new atributo("ID","USUARIOS"),
								  new atributo("STYLE","border:1px solid #c0c0c0;padding:10px;vertical-align:top;")),
							$this->geraTelaUsuarios()));
			
		$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
							Array(new atributo("ID","PERMISSOES"),
								  new atributo("STYLE","border:1px solid #c0c0c0;padding:10px;vertical-align:top;"))));
		echo utf8_encode($_sct->toHTML() . $_tab->toHTML());
	}
	
	public function retornaPermissoes($_usuario) {
		$_permissoes = Array();
		if($this->buscar(Array('USUARIO_ID'=>$_usuario))!==false) {
			while($this->proximo()!==false) {
				$_permissoes[$this->getCampo("MENU_ID")->getValor()] = $this->getCampo("PERMISSAO_MODO")->getValor();
			}
		}
		return $_permissoes;
	}
	
	/**
	 * Gera um formulário com os menus e permissões
	 * do usuário informado
	 */
	public function geraPermissoes() {
		// Buscar as permissões
		$_permusr = $this->retornaPermissoes($_POST["usuario"]);
		$_menu = new menu($this->_conn);
		$_arvore = $_menu->geraArvoreMenu();
		$_frm = new formulario("FRM_PERM","javascript:void(0)");
		$_frm->AddSubTag(new tag(new tipotag("SCRIPT"),null,
							"function PERMMarcaFilhos(pref,el) {" . 
							"var inputs=document.getElementsByTagName('input');for(var j=0;j&lt;inputs.length;j++) {" . 
							"if(inputs[j].id.indexOf(pref)==0) { inputs[j].checked=el.checked;}}};" . 
							"function PERMSalvar() {document.getElementById('REC_PERM').innerHTML='';var params = '';" . 
							"var inputs=document.getElementsByTagName('input');for(var j=0;j&lt;inputs.length;j++) {" . 
							"if(inputs[j].type=='checkbox') {" .
							"params += '&'+inputs[j].id + '=' + (inputs[j].checked ? 'AUT' : 'NEG')};" . 
							"};params += '&usuario={$_POST['usuario']}&classe=permissao&arquivo_classe=framework/classes/classe_permissao.inc" .
							"&metodo=salvaPermissoes';" .
							"ObjProcAjax.runPost('executa_busca_ajax.php5','REC_PERM',params)};"));
		$_frm->deleteAtributo(4);
		$_frm->addAtributo(new atributo("ONSUBMIT","PERMSalvar();return false;"));
		$_tab = new tag(new tipotag("TABLE"),
							Array(new atributo("BORDER",0),
								  new atributo("CELLPADDING",0),
								  new atributo("CELLSPACING",0),
								  new atributo("VALIGN","TOP"),
								  new atributo("STYLE","width:100%;padding-top:10px;border:1px solid #c0c0c0;border-collapse:collapse;")));
		$_tab->addSubTag(new tag(new tipotag("TR")));
		$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
							Array(new atributo("STYLE","width:80%;border:1px solid #c0c0c0;text-align:center")),
							"Item"));
		$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
							Array(new atributo("STYLE","width:20%;border:1px solid #c0c0c0;text-align:center")),
							"Autorizado"));
		foreach($_arvore as $_ramo) {
			$this->geraItem($_tab,$_ramo,$_permusr);
		}
		$_frm->addSubTag($_tab);
		$_frm->addSubTag(new tag(new tipotag("DIV"),
							Array(new atributo("STYLE","border:1px none;text-align:center;padding:10px;"))));
		$_frm->getLastSubTag()->addSubTag(new formInputSubmit("GRAVAR"," Salvar Permissões "));
		$_frm->addSubTag(new tag(new tipotag("DIV"),
							Array(new atributo("ID","REC_PERM"),new atributo("ALIGN","CENTER"))));
		echo utf8_encode($_frm->toHTML(false));
	}
	
	/**
	 * Gera os itens do menus com sua permissão marcada (autorizado ou negado)
	 *
	 * @param tag     $_tab			objeto com a classe html para a tabela
	 * @param Array   $_ramo		lista contendo o ramo atual e seus filhos
	 * @param Array   $_permissoes	lista com as permissões do usuário
	 * @param integer $_nivel		nivel atual (profundidade do ramo)
	 * @param string  $_prefixo		prefixo para acrescentar ao nome do campo checkbox no formulário
	 */
	protected function geraItem(tag &$_tab,$_ramo,$_permissoes,$_nivel=0,$_prefixo="0") {
		$_tab->addSubTag(new tag(new tipotag("TR"),
						Array(new atributo("ONMOUSEOVER","this.className='detalhe';"),
							  new atributo("ONMOUSEOUT","this.className='';"))));
		$_pleft = ($_ramo[3]==''||$_ramo[3]===null ? 25 : 0);
		$_style = "padding-left:" . ($_nivel*30+$_pleft) . "px;padding-bottom:5px;padding-top:3px;border-bottom:1px solid #c0c0c0;border-right:1px solid #c0c0c0;" . 
				  ($_nivel==0 ? "font-weight:bold;" : "");
		$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
							Array(new atributo("STYLE",$_style))));
		if($_ramo[3]!=''&&$_ramo[3]!==null) {
			$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("IMG",false),
							  Array(new atributo("SRC","framework/imagens/{$_ramo[3]}"),
							  		new atributo("WIDTH",20),
							  		new atributo("BORDER",0),
							  		new atributo("ALIGN","ABSMIDDLE"))));
		}
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new tag(new tipotag("SPAN"),null,"{$_ramo[0]}-{$_ramo[1]}"));
		$_tab->getLastSubTag()->addSubTag(new tag(new tipotag("TD"),
						  Array(new atributo("STYLE","text-align:center;padding-bottom:5px;border-bottom:1px solid #c0c0c0;"))));
		$_tab->getLastSubTag()->getLastSubTag()->addSubTag(new formInputCheckBox("{$_prefixo}_{$_ramo[0]}_AUT","AUT",null,null,null,!($_permissoes[$_ramo[0]]=='NEG')));
		if($_ramo[4]!==null) {
			$_tab->getLastSubTag()->getLastSubTag()->getLastSubTag()->addAtributo(new atributo("ONCLICK","PERMMarcaFilhos('{$_prefixo}_{$_ramo[0]}',this)"));
			foreach($_ramo[4] as $_folha) {
				$this->geraItem($_tab,$_folha,$_permissoes,$_nivel+1,"{$_prefixo}_{$_ramo[0]}");
			}
		}
	}
	
	/**
	 * Salva as permissões de um usuário
	 *
	 */
	public function salvaPermissoes() {
		$this->_conn->startTransaction();
		// Antes devemos limpar
		if($this->_conn->executaSQL("DELETE FROM {$this->_nome_tabela} WHERE USUARIO_ID={$_POST['usuario']}")===false) {
			$this->_conn->ROLLBACK();
			die(utf8_encode("<span style='color:red;'>Erro na Execução do processo {$this->_conn->getUltimoErro()}<span>"));
		}
		// Agora inserimos cada um deles
		$this->getCampo("USUARIO_ID")->setValor($_POST['usuario']);
		foreach($_POST as $_chv=>$_vlr) {
			if(ereg("^(.*)_AUT$",$_chv,$_arr)) {
				ereg("^.*_{0,1}([0-9]{1,})_([0-9]{1,})$",$_arr[1],$_menu);
				if($_vlr=="NEG"||($_vlrsup[$_menu[1]]=="NEG"&&$_vlr=="AUT")) {
					$this->getCampo("MENU_ID")->setValor($_menu[2]);
					$this->getCampo("PERMISSAO_MODO")->setValor($_vlr);
					if($this->incluir()===false) {
						$this->_conn->ROLLBACK();
						die(utf8_encode("<span style='color:red;'>Erro na Inclusão da permissão: {$this->_conn->getUltimoErro()}<span>"));
					}
				}
				$_vlrsup[$_menu[2]] = $_vlr;
			}
		}
		$this->_conn->commit();
		echo utf8_encode("<span style='color:#0099ff;'>Permissões geradas com sucesso!!</span>");
	}
	
	public function getFormularioFiltro() {
		$this->filtroNaoSuportado();	
	}
}
?>