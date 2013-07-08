<?php
	abstract class veiculo {
		protected $_marca;
		protected $_modelo;
		
		abstract protected function getTipo(); 
		
		public function printTipo() {
			echo $this->getTipo();
		}
	}
	class carro extends veiculo {
		protected function getTipo() {
			return "Automóvel<br/>";
		}
	}
	class bicicleta extends veiculo {
		protected function getTipo() {
			return "Bicicleta<br/>";
		}
	}

	$_c = new carro;
	$_c->printTipo();
	$_c = new bicicleta;
	$_c->printTipo();
	$_c = new veiculo; // ERRO
?>
