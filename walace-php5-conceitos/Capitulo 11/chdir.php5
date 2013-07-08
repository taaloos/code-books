<?php
	echo "Diretório Atual: " . getcwd() .  "<br/> ";
	$_dir = "../Capitulo 10";
	if(chdir($_dir)===FALSE) {
		echo "O Diretório $_dir não existe ou você não tem permissão..";
	}
	else {
		echo "Diretório Atual: " . getcwd() .  "<br/> ";
	}
?> 
 
