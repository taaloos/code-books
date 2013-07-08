<?php
	// Define a interface minima para as classe de tabelas...
	interface ITabela {
		public function Incluir();
		public function Alterar();
		public function Excluir();
		public function Listar(); 
		public function Buscar($_valor);
	}
?>	
