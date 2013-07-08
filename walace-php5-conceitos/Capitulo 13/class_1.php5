<?php
	class carro {
		private $_marca;
		private $_modelo;
		private $_cor;
		private $_ano;
	
		public function setMarca($_m) {
			$this->_marca = $_m;
		}
		public function setModelo($_m) {
			$this->_modelo = $_m;
		}
		public function setcor($_c) {
			$this->_cor = $_c;
		}
		public function setAno($_a) {
			if(is_int($_a)) {
				$this->_ano = $_a;
			}
			else {
				return FALSE;
			}
		}

		public function getMarca() {
			return $this->_marca;
		}
		public function getModelo() {
			return $this->_modelo;
		}
		public function getCor() {
			return $this->_cor;
		}
		public function getAno() {
			return $this->_ano;
		}

		public function getCarro() {
			return "Marca: " . $this->getMarca() .  "<br/>" . 
				  "Modelo: " . $this->getModelo() . "<br/>" .
				  "Cor: " . $this->getCor() . "<br/>" . 
				  "Ano: "  . $this->getAno();
		}
	}
	
	$_c = new carro();
	$_c->setMarca("FORD");
	$_c->setModelo("Fiesta");
	$_c->setCor("Preto");
	$_c->setAno(2004);
	echo $_c->getMarca();
	echo "<br/>";
	echo $_c->getCarro();
	$_c->_modelo = "KA";  // Teremos um erro aqui..
?> 
