<?php
	$valor = "<B><FONT COLOR='RED'>Exemplo   de htmlentities()       </B></FONT><BR>";
	echo $valor;
	echo htmlentities($valor);
	echo "<br>";
	echo htmlentities($valor,ENT_QUOTES);
?>
