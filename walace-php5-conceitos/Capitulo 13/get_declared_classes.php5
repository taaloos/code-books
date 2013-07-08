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
	
	echo "<pre>";
	print_r(get_declared_classes());
	echo "</pre>";
?>

