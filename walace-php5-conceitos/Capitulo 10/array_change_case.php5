<?php
	$_arr = Array("cor"=>"Verde","nome"=>"Walace",
				  "Cor"=>"Branco","cIdaDe"=>"São Paulo");	
	$_arr_up = array_change_case($_arr,CASE_UPPER);
	echo "<PRE>";
	print_r($_arr);
	print_r($_arr_up);
	echo "</PRE>";
?>
