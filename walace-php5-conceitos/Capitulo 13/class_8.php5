<?php
	class carro {
		protected $_marca;
		protected $_modelo;
		protected $_cor;
		protected $_ano;
		function __construct($mr="",$md="",$c="",$a=0) {
			$this->setMarca($mr);
			$this->setModelo($md);
			$this->setCor($c);
			$this->setAno($a);
		}
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
					  "Ano: "  . $this->getAno() . "<br/>";
		}
		function __destruct() {
			echo  $this->getCarro();
			echo "__FIM (Carro)__<br/>";
		}
	}
	echo "<pre>";
	Reflection::export(new ReflectionClass('carro'));
	echo "</pre>";
?>
