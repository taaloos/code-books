<?php
/**
 * Retorna uma lista com as unidades federativas
 */
$_ufs = Array("AC"=>"Acre","AL"=>"Alaqoas","AM"=>"Amazonas","AP"=>"Amapa","BA"=>"Bahia","CE"=>"Ceará",
			"DF"=>"Distrito Federal","ES"=>"Espirito Santo","GO"=>"Goias","MA"=>"Maranhão","MG"=>"Minas Gerais",
			"MS"=>"Mato Grosso do Sul","MT"=>"Mato Grosso","PA"=>"Pará","PB"=>"Paraiba","PE"=>"Pernambuco",
			"PI"=>"Piaui","PR"=>"Paraná","RJ"=>"Rio de Janeiro","RN"=>"Rio Grande do Norte","RO"=>"Rondônia",
			"RR"=>"Roraima","RS"=>"Rio Grande do Sul","SC"=>"Santa Catarina","SE"=>"Sergipe","SP"=>"São Paulo",
			"TO"=>"Tocantins");

$_lista = "";
foreach($_ufs as $_sigla=>$_uf) {
	if(stripos($_uf,utf8_decode($_POST['valor']))!==false||strtolower($_sigla)==strtolower($_POST['valor'])) {
		$_lista .= "<li valor=\"{$_sigla}\" target=\"{$_POST['target']}\">{$_uf}</li>";
	}
}
if($_lista=="") {
	$_lista = "<li valor=\"0\" target=\"{$_POST['target']}\">Nenhum Resultado</li>";
}
//sleep(5);
echo utf8_encode("<ul>{$_lista}</ul>");
?>