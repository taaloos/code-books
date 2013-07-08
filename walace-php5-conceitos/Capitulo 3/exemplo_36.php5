<?php
	$s1 =  "Titulo: \"PHP5 - Guia do Programador\" ";
	$s2 = <<< EOL
Exemplo da sintaxe heredoc, os caracteres escape
Funcionam, por exemplo \\ (barra invertida) e \$,
Além disto a expansão de variáveis também.
\$s1  = $s1 
EOL;
	echo "$s1<br><pre>$s2</pre>";
?>
