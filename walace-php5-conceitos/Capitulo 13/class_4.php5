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
	class caminhão extends carro {
		protected $_eixos;
		function __construct($mr="",$md="",$c="",$a=0,$ne=0) {
			parent::__construct($mr,$md,$c,$a);
			$this->setEixo($ne);
		}
		public function setEixo($_ne) {
			$this->_eixos = $_ne;
		}
		public function getEixo() {
			return $this->_eixos;
		}
		public function getCarro() {
			return parent::getCarro() . 
					  "Eixos: " . $this->getEixo() . "<br/>";
		}
		function __destruct() {
			parent::__destruct();
			$this->getCarro();
			echo "___FIM (Caminhão)___<br/>";
		}
	}
	$_c = new carro("AUDI","A3","PRETO",2004);
	$_c->getCarro();
	$_c = new caminhão("MB","1113","Vermelho",1998,4);
	$_c->getCarro();
?>
