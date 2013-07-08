<?php
	$texto = "<b>Exemplo de Strig_tags</b><script>alert('Este é um Java";
	$texto.= "script embutido no texto')</script>";
	echo $texto . "<br>";
	echo strip_tags($texto,"<b>");
?>
