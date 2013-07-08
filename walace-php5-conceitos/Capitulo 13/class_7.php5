<?php
	interface Itabela {	
		public function setBD($_bd);
		public function busca($_codigo);
	}

	class usuario implements Itabela {
		protected $_bd;
		protected $_qry;
		private  $_sql;
		protected $_usr_cod;
		protected $_usr_nome;
		protected $_usr_telefone;
		protected $_usr_endereco;

		public function setBD($_bd) {
			$this->_bd = $_bd;
		}
		protected function preenche() {
			$this->_usr_cod = $this->_qry["USR_COD"];
			$this->_usr_nome = $this->_qry["USR_NOME"];
			$this->_usr_telefone = $this->_qry["USR_TEL"];
			$this->_usr_endereco = $this->_qry["USR_ENDER"];
		}				
		protected function valida() {
			if($this->_usr_nome=="") {
					return FALSE;
			}
			return TRUE;
		}
		public function busca($_codigo) {
			$this->_sql = "SELECT * FROM Usuario WHERE " .
						  " USR_COD = $_codigo";
			$this->_qry = mysql_query($this->_sql,$this->_bd);
			if($this->_qry===FALSE) {
				return FALSE;
			}

			if(mysql_num_rows($this->_qry)>0) {
				$this->preenche();
			}
			return TRUE;
		}
	}
	$_con = mysql_connect("localhost","root","");
	mysql_select_db("zeus_controle_tng",$_con);
	$usr = new usuario;
	$usr->setBD($_con);
	var_dump($usr->busca(10));	
?>
