<?php
	class carro {
		public $_modelo;
		public function setModelo($_m) {
			$this->_modelo = $_m;
		}
	}
	$_c = new carro();
	$_c->setModelo("FORD");
	$_c->_modelo = "CHEVROLET";
	echo $_c->_modelo;
?>
