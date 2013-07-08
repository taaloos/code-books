<?php
	class mostra_arquivo {
		protected $_nome_arq;
		private $_flg;
		function __construct() {
 			$this->_nome_arq = $_nome;
			$this->_flg = FALSE;
		}
		public function setArq($_nome) {
			if(file_exists($_nome)) {
				$this->_nome_arq = $_nome;
				$this->_flg = TRUE;
			}
			else {
				throw new exception("Arquivo Informado não Existe",4);
			}
		}
		public function mostra() {
			if($this->_flg===FALSE) {
				throw new exception("Arquivo não informado",10);
			}
			elseif(file_exists($this->_nome_arq)) {
				if(filesize($this->_nome_arq)==0) {
					throw new exception("Arquivo Vazio");
				}
				echo "<pre>";
				echo htmlentities(file_get_contents($this->_nome_arq));
				echo "</pre>";
			}
			else {
				throw new exception("Arquivo Informado não Existe",40);
			}
		}
	}
	
	$a = new mostra_arquivo;
	//$a->setArq("./class_x.php5");
	//$a->mostra();
	$a->setArq("arquivo.txt");
	$a->mostra();
?>
