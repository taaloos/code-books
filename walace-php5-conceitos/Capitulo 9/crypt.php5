<?php
	$valor = "MinhaSenha";
	$c1 = crypt($valor);
	$c2 = crypt($valor,"$1$.;pzw12&!");
	echo "$valor <br> $c1 <br> $c2";
?>
