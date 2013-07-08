<?php
/**
 * Configurador de Sistemas existentes no framework
 * Não incluir o próprio Framework
 * O formato deve ser
 * Array('Sistema/Módulo'=>Diretório, ...)
 * Exemplo:
 * 	Array(
 * 			'Estoque/Cadastros'=>'estoque/cadastros/',
 * 			'Estoque/Relatórios'=>'estoque/relatorios/',
 * 			'Estoque/Processos'=>'estoque/processos/'
 * 		);
 * A chave 'Sistema/Módulo' será exibida na inclusão de menus
 */
return 	Array('Estoque'=>'estoque/');
?>