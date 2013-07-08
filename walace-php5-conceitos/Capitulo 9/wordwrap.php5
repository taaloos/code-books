<?php
	$texto = "A função wrodwrap insere na string informada o caracter de
			quebra de linha \\n (ou um outro caracter qualquer, por exemplo
			<BR>), a cada n caracteres (o padrão é 75). O parâmetro corte
			serve para forçarmos a quebra mesmo para palavras extremamente
			exxxxxxxxteeeeeeeeeeeeenssssssssssssssaaaaaaaaaaasssssssss.";
	$texto = htmlentities($texto);
	echo wordwrap($texto);
	echo "<br><br><b>Sem o parâmetro corte:</b><br>";
	echo wordwrap($texto,30,"<br/>");
	echo "<br><br><b>Cem o parâmetro corte:</b><br>";
	echo wordwrap($texto,30,"<br/>",TRUE);
?>
