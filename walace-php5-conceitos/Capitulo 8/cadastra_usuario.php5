<html>
<head>
  <title>PHP5 - Guia do Programador - Exemplo de um formulário WEB</title>
</head>
<body>
<table border="0" cellpadding="3" cellspacing="0" width="100%">
  			<tr>
			  <td height="30" bgcolor="#8CDAFF">
					<b>PHP 5 - Guia do Programador: Cadastro de Usuário</b>
			  </td>
			  <td align="right" bgcolor="#8CDAFF">
			    <?=date("d-m-Y H:i:s")?>&nbsp;
			  </td>
			</tr>
</table>
<?php
	/* 	cadastra_usuario.php5
		Validação dos dados informados no formulário de cadastro
		Walace Soares
		Janeiro de 2004
	*/
	$erro = Array(); // Array com os erros encontrados
	// Vamos verificar se existe algum campo não informado
	foreach($_POST as $chv => $vlr) {
		if($vlr=="" AND substr($chv,0,3)=="USR") {
			$erro[] = "O campo " . substr($chv,4) . " Não foi informado";
		}
	}
	if(sizeof($erro)==0) {
		// Ok -> vejamos se a senha está OK
		if($_POST["USR_SENHA"]!=$_POST["USR_SENHA2"]) {
			$erro[] = "Senha não confere com a confirmação de senha";
		}
	}
	if(sizeof($erro)==0) {
		// Tudo Ok, mostramos os dados 
		echo  '<p align="left"><font color="navy"><b>';
		echo 'Dados informados no Cadastro:</b></font></p>';
		echo '<table border=0 cellpadding=5 cellspacing=5>';
		reset($_POST);
		foreach($_POST as $chv => $vlr) {
			if(substr($chv,0,3)=="USR") {
				echo "<tr><td>" . ucfirst(strtolower(substr($chv,4))) . "</td> ";
				echo "<td><b>" . $vlr . "</b></td></tr>\n";
			}
		}
		echo '<tr><td height=60 valign="bottom"><b>Obrigado!</td></tr>';
		echo '</table>';
	}
	else {
		// Mensagem de erro
		echo  '<p align="center"><font color="red"><b>';
		foreach($erro as $vlr) {
			echo "$vlr<br>";
		}
		echo '</b></font>';
		echo '<a href="exemplo_81.php5">Voltar</a></p>';
	}
?>
</body>
</html>