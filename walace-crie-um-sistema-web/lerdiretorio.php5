<?php
function lerDiretorio($_dir,$_nivel=0) {
	$_d = dir($_dir);
	$_lista = "";
	while(($_e=$_d->read())!==false) {
		if($_e!="."&&$_e!="..") {
			$_lista .= "<span style='padding-left:" . ($_nivel*20) . "px;font-size:12px;'>";
			if(is_dir("{$_dir}/{$_e}")) {
				$_lista .= "<img src='framework/imagens/pasta.png' 	onclick=\"var d=document.getElementById('d_{$_e}');" . 
				"if(d.style.display==='none') {d.style.display='block'} else {d.style.display='none';}\" " . 
				"width='15' border=0 align='absmiddle'>&nbsp;&nbsp;";
			}
			$_lista .= $_e . "</span><br>";
			if(is_dir("{$_dir}/{$_e}")) {
				$_lista .= "<div id='d_{$_e}'>" . lerDiretorio("{$_dir}/{$_e}",$_nivel+1) . "</div>";
			}
		}
	}
	return $_lista;
}
echo "<span style='padding-left:0px;font-size:15px;font-weight:bold;'>
	 <img src='framework/imagens/pasta.png' width='15' border=0 align='absmiddle'>&nbsp;&nbsp;sistema_web</span><br>";
echo lerDiretorio("d:/www/sistema_web/",1);
?>