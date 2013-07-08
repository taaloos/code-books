<html>
<head>
	<title>PHP5 - Guia do Programador - Exemplo de um formulário WEB com Upload de arquivo</title>
</head>
<body>
<table border="0" cellpadding="3" cellspacing="0" width="100%">
	<tr>
		  <td height="30" bgcolor="#8CDAFF">
				<b>PHP 5 - Guia do Programador: Upload de Arquivo</b>
		  </td>
		  <td align="right" bgcolor="#8CDAFF">
		    <?=date("d-m-Y H:i:s")?>&nbsp;
		  </td>
	</tr>
</table>
<form name="usr" enctype="multipart/form-data" method="post" action="upload.php5">
	<table border="0" cellpadding="5" cellspacing="5">
		<tr>
		  <td height="30"><b>Arquivo:</b></td>
		  <td height="30" >
		  	<input type="hidden" name="MAX_FILE_SIZE" value="100000">
			<input type="FILE" name="ARQUIVO" size="50">
		  </td>
		</tr>
		<tr>
		  <td colspan=2 align>
			<input type="submit"  value=" Enviar o Arquivo">
		  </td>
		</tr>
	</table>
</form>
</body>
</html>
