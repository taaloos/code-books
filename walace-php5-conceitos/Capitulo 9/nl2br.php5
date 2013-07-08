<?php
	$texto = "Este é um texto\ncom line-feed como quebra\n de página";
	echo "sem nl2br():<br>$texto<br><br>Com nl2br():<br>" . nl2br($texto);
?>
