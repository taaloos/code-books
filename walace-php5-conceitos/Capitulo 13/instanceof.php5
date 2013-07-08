<?php
	class pessoas {
		private $_tipo;
		protected $_nome;
		protected $_endereço;
		protected $_telefone;
		protected function setTipo($_t) {
				$this->_tipo = $_t;
		}
	}
	class estudante extends pessoas {
		protected $_curso;
		function __CONSTRUCTOR() {
			parent::setTipo("E");
		}
	}
	
	$_c = new estudante;
	if($_c instanceof  pessoas) {
		echo "$_c é uma instancia da classe pessoas<br/>";
	}
	$_c = new pessoas;
	if($_c instanceof  estudante) {
		echo "$_c é uma instancia da classe estudante<br/>";
	} else {
		echo "$_c não é uma instancia da classe estudante,";
		echo "E sim da classe "  . get_class($_c);
	}
?>
