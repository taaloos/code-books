<?php
	class carro {
		protected $_modelo;
		public function setModelo($_m) {
			$this->_modelo = $_m;
		}
	}
	class caminhão extends carro {
		protected $_eixos;
		public function setModelo($_m) {
			$this->_modelo = $_m;
		}
		public function setEixo($_ne) {
			$this->_eixos = $_ne;
		}
	}
	$_c = new carro();
	$_c->setModelo("FORD");
	//$_c->_modelo = "CHEVROLET";
	$_c = new caminhão();
	$_c->setModelo("SCANIA");
	$_c->setEixo(8);
	var_dump($_c);
?>
