<?php
		function lista_estados($nome_campo="USR_UF",$MULT=FALSE) {
			$ufs = array("SP" => "São Paulo",
							"ES" => "Espírito Santo",
							"RJ" => "Rio de Janeiro",
							"MG" => "Minas Gerais",
							"RS" => "Rio Grande do Sul",
							"AM" => "Amazonas",
							"CE" => "Ceará",
							"BA" => "Bahia",
							"MT" => "Mato Grosso");
			$ret = "<SELECT NAME='$nome_campo'";
			$ret.= ($MULT) ? " MULTIPLE" : "";
			$ret.= ">\n";
			foreach($ufs as $chv => $vlr) {
					$ret.=	 "<OPTION VALUE='$chv'>$vlr</OPTION>\n";
			}
			$ret.= "</SELECT>\n";
			return $ret;
		}
?>
<?=lista_estados();?>

