<?php
/**
 * Classe para montagem de um botão com imagem
 *
 */
class Botao extends tag{
	public function __construct($_src,$_link,$_titulo, Eventos $_eventos=null) {
		parent::__construct(new tipotag("A"),
							Array(new atributo("HREF",$_link),
								  new atributo("STYLE","text-decoration:none;"),
								  new atributo("CLASS","botao")));
		$this->addSubTag(new tag(new tipotag("IMG",false),
						Array(new atributo("SRC","framework/imagens/{$_src}"),
							  new atributo("BORDER",0),
							  new atributo("TITLE",$_titulo),
							  new atributo("ID","TOOLTIP"),
							  new atributo("NAME","{$_titulo}"),
							  new atributo("STYLE","height:22px;padding:3px;"),
							  new atributo("ALIGN","ABSMIDDLE"))));

	}
}

/**
 * Monta uma barra de botões
 *
 */
class BarraBotoes {
	/**
	 * Lista de Botões
	 * Opcionalmente pode conter separadores
	 * seu formato é Array(Array(nome,botao|null,separador)
	 * o terceiro elemento indica se é um separador ou não (true=sim)
	 *
	 * @var array
	 */
	protected $_botoes = Array();
	
	public function addBotao($_nome="BTN",Botao $_btn) {
		$this->_botoes[] = Array($_nome,$_btn);
	}
	
	public function addSeparador($_nome="SEP") {
		$_sep = new tag(new tipotag("IMG"),
						Array(new atributo("SRC","framework/imagens/separador.png"),
							  new atributo("BORDER",0),
							  new atributo("CLASS","separador"),
							  new atributo("ALIGN","ABSMIDDLE")));
		$this->_botoes[] = Array($_nome,$_sep);
	}
	
	public function delBotao($_nome) {
		foreach($this->_botoes as $_pos=>$_botao) {
			if($_botao[0]==$_nome) {
				unset($this->_botoes[$_pos]);
			}
		}
	}
	
	public function clear() {
		$this->_botoes = Array();
	}
	
	public function toHTML() {
		$_html = "";
		foreach($this->_botoes as $_botao) {
			$_html .= $_botao[1]->toHTML();
		}
		return $_html;
	}
	
}

/**
 * Monta a Barra padrão de botões
 *
 */
class BarraPadrao {
	public static function montaBarraPadrao() {
		$_barra = new BarraBotoes();
		$_barra->addBotao("RELAT",new Botao("relatorio.png","javascript:objRelatorio.exibir();"," Relatório "));
		$_barra->addSeparador();
		$_barra->addBotao("HISTORICO",new Botao("clock.png","javascript:historico();"," Histórico "));
		$_barra->addBotao("FAVORITOS",new Botao("favoritos.png","javascript:favoritos();"," Favoritos "));
		$_barra->addSeparador();
		$_barra->addBotao("SEARCH",new Botao("search.png","javascript:filtrar();"," Filtro de registros"));
		$_barra->addBotao("CANCEL",new Botao("cancel_search.png","javascript:limparFiltro();"," Limpar Filtro "));
		$_barra->addSeparador();
		$_barra->addBotao("HOME",new Botao("home.png","index.php5","Página inicial"));
		$_barra->addBotao("EXIT",new Botao("logout_peq.png","login.php5","Sair do Sistema"));
		return $_barra->toHTML();
	}
}
?>