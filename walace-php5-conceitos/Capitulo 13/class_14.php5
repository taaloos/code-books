<?php
	class EArquivoNaoExiste extends Exception{}
	class EformatoArquivo extends Exception{}
	class EconteudoArquivo extends Exception{}
	
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
				throw new EArquivoNaoExiste($_nome);
			}
		}
		public function mostra() {
			if($this->_flg===FALSE) {
				throw new exception("Arquivo não informado",10);
			}
			elseif(file_exists($this->_nome_arq)) {
				if(is_executable($this->_nome_arq) OR is_dir($this->_nome_arq)) {
					throw new EFormatoArquivo($this->_nome_arq);
				}
				if(filesize($this->_nome_arq)==0) {
					throw new EConteudoArquivo("Vazio");
				}
				echo "<pre>";
				echo htmlentities(file_get_contents($this->_nome_arq));
				echo "</pre>";
			}
			else {
				throw new EArquivoNaoExiste($this->_nome_arq);
			}
		}
	}
	

	function exibe($_na) {
		$_a = new mostra_arquivo;
		try {
			$_a->setArq($_na); 
			$_a->mostra();
		} catch (EArquivoNaoExiste $e) {
			echo "(Erro) O Arquivo " . $e->getMessage() . " Não Existe!<br/>";
		} catch (EConteudoArquivo $e) {								   
			echo "(Erro) O Arquivo informado está " . $e->getMessage() . "<br/>";
		} catch (EFormatoArquivo $e) {								   
			echo "(Erro) O Formato do Arquivo não é válido (" . $e->getMessage() . ")<br/>";
		} catch (Exception $e) {
			echo "ERRO Desconhecido: " . $e->getCode() . "-" . $e->getMessage() . "<br/>";
			exit();
		} 
	}

	exibe("Arquivo.txt"); // Erro
	exibe("c:/PHP/php.exe");
	exibe("");
	exibe("class_11.php5");  // OK	
	
?>
