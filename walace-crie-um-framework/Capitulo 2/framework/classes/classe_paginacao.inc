<?php
/**
 * Classe responsavel pela montagem da lista 
 * de páginas de um conjunto de dados
 *
 */
class paginacao {
	const REGISTROS_PAGINA = 20;	
	const INTERVALO = 16;
	
	private static function getListaPaginas($_pagina_atual,$_numero_paginas) {
		$_paginas = Array();
		if($_pagina_atual>1) {
			$_paginas[] = 1;
			$_paginas[] = "...";
		}
		$_ultima_pagina = $_pagina_atual+self::INTERVALO-1;
		if($_ultima_pagina>$_numero_paginas) {
			$_ultima_pagina = $_numero_paginas;
		} 
		if($_numero_paginas-$_pagina_atual<self::INTERVALO) {
			$_pagina_atual = $_numero_paginas-self::INTERVALO;
			if($_pagina_atual<1) { 
				$_pagina_atual = 1;
			}
		}
		for($_pagina=$_pagina_atual;$_pagina<=$_ultima_pagina;$_pagina++) {
			$_paginas[] = $_pagina;
		}
		if($_ultima_pagina!=$_numero_paginas) {
			$_paginas[] = "...";
			$_paginas[] = $_numero_paginas;
		}
		return $_paginas;
	}
	
	private static function incluirLink($_paginas,$_pagina_atual,$_total_registros,$_ajax,$_div) {
		$_pagina_anterior=1;
		foreach($_paginas as $_idx=>$_pagina) {
			$_goto = ($_pagina=="...") ? floor(($_paginas[$_idx+1]-$_pagina_anterior)/2)+$_pagina_anterior : $_pagina;
			$_pagina = ($_pagina==$_pagina_atual 
									? "<span class='nohover' style='font-size:18px;vertical-align:middle;border:1px solid #990033;
										padding:2px;font-weight:bold;color:#990033;'>{$_pagina}</span>" 
									: "<span style='font-size:13px;vertical-align:middle;'>{$_pagina}</span>");
			$_url = "{$_SERVER['PHP_SELF']}?pagina={$_goto}&total_registros={$_total_registros}" . ($_ajax===true ? "&AJAX=S" : "");
			if($_ajax===true) {
				$_href = "href=\"javascript:void(0);\" onclick=\"paginacao('{$_url}','{$_div}');\"";
			} else {
				$_href = "href=\"{$_url}\"";
			} 
			$_paginas[$_idx] = "<a {$_href} class='nohover' style='text-decoration:none;color:Navy;'>{$_pagina}</a>";
			$_pagina_anterior = $_goto;
		}
		return $_paginas;
	}
	
	public static function paginar($_total_registros,$_pagina_atual,$_registros_pagina=null,$_ajax=false,$_div='PAGINACAO') {
		if((int)$_registros_pagina<=0) {
			$_registros_pagina = self::REGISTROS_PAGINA;
		}
		$_numero_paginas = ceil($_total_registros/$_registros_pagina);
		return self::incluirLink(self::getListaPaginas($_pagina_atual,$_numero_paginas),$_pagina_atual,$_total_registros,$_ajax,$_div);
	}
	
	public static function getLimit($_pagina) {
		$_pagina = $_pagina>0 ? $_pagina : 1;
		return array("LIMIT"=>self::REGISTROS_PAGINA,"OFFSET"=>($_pagina-1)*self::REGISTROS_PAGINA);
	}
	
	public static function getChamadaAjax() {
		return "function paginacao(url,div) {" . 
			   "var ax=new AJAX();" . 
			   "ax.url=url;" .
			   "ax.div=div;" .  
			   "document.getElementById(div).style.cursor='wait';" . 
			   "ax.processaresultado=function(html) {" . 
			   "document.getElementById(div).innerHTML = html;" .
			   "document.getElementById(div).style.cursor='default';" . 
			   "};" . 
			   "ax.conectar();}";
	}
	
}

?>