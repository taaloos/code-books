<?php
	$_arr = Array("Nome","Telefone","Cidade");
	$_arr_v = Array("Mara Soares","+55115555-1055","São Paulo");
	$_arr_2 = Array("João");
	echo "<PRE>";
	print_r(array_combine($_arr,$_arr_v));
	echo "</PRE>";
?>
