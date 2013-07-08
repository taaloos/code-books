<?php
/**
 * Classe Básica para acesso a Banco de dados
 *	@abstract 
 */
abstract class BancoDados {
	protected $_Tipo = null;	// Definido por cada banco de dados
	protected $_Servidor = 'localhost';
	protected $_Porta = 0;
	protected $_Usuario;
	protected $_Senha;
	protected $_Banco;
	protected $_conn = false;
	protected $_dataset = false;
	protected $_numrows = -1;
	protected $_tupla = false;
	protected $_posatual = -1;
	protected $_ultimoerro = "";
	protected $_ind_case = CASE_UPPER;

	abstract public function Conectar();
	abstract public function executaSQL($_sql);
	abstract protected function SetNumRows();
	abstract protected function navegainterno($_pos);
	abstract protected function proximointerno();
	abstract public function escapeString($_str);
	abstract public function getLimit($_arr);
	abstract protected function SetAffectedRows();
	abstract public function multiqueries($_sql);
	
	public function SetServidor($_servidor) {
		$this->_Servidor = $_servidor; 
	}
	
	public function SetPorta($_porta) {
		$this->_Porta = $_porta;
	}
	
	public function SetUsuario($_usuario) {
		$this->_Usuario = $_usuario;
	}
	
	public function SetSenha($_senha) {
		$this->_Senha = $_senha;
	}
	
	public function SetBanco($_banco) {
		$this->_Banco = $_banco;
	}
	
	public function startTransaction() {
		$this->executaSQL('START TRANSACTION');
	}

	public function commit() {
		$this->executaSQL('COMMIT');
	}
	
	public function ROLLBACK() {
		$this->executaSQL('ROLLBACK');
	}
	
	protected function isSELECT($_sql,$_res) {
		$this->_dataset = $_res;
		if(substr(trim(strtolower($_sql)),0,6)=='select') {
			$this->SetNumRows();
		} elseif(substr(trim(strtolower($_sql)),0,6)!='commit') {
			$this->SetAffectedRows();
		}
	}
	
	public function setCase($_case=CASE_UPPER) {
		$this->_ind_case = in_array($_case,Array(CASE_LOWER,CASE_NATURAL,CASE_UPPER)) ? $_case : CASE_UPPER;
	}
	
	public function getNumRows() {
		return $this->_numrows;
	}
	
	public function transforma() {
		$this->_tupla = $this->_tupla!==false&&$this->_tupla!==null ? array_change_key_case($this->_tupla,$this->_ind_case) : $this->_tupla;
	}
	
	
	public function navega($_pos=0) {
		$this->_tupla = false;
		$this->navegainterno($_pos);
		$this->_posatual = $_pos;
		$this->transforma();
		return $this->_tupla;
	}
	
	public function primeiro() {
		return $this->navega();
	}
	
	public function proximo() {
		$this->_tupla = false;
		$this->proximointerno();
		$this->_posatual++;
		$this->transforma();
		return $this->_tupla;
	}

	public function anterior() {
		return $this->navega($this->_posatual-1);
	}
	
	public function ultimo() {
		return $this->navega($this->_numrows-1);
	}
	
	public function getDadosAtual() {
		return $this->_tupla; 
	}
	
	public function getUltimoErro() {
		return "[{$this->_Tipo}]: {$this->_ultimoerro}";
	}

	public function converteDataToBD($_data) {
		// $_data Sempre no formato dd-mm-YYYY
		if(ereg("^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4}).*$",$_data,$_arrdt)!==false) {
			return sprintf("'%04.4d-%02.2d-%02.2d'",$_arrdt[3],$_arrdt[2],$_arrdt[1]);
		}
		return false;
	}
	
	public function converteDataHoraToBD($_dtime) {
		// $_dtime Sempre no formato dd-mm-YYYY HH:MM:SS
		if(ereg("^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})[[:space:]]([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}).*$",$_dtime,$_arrdt)!==false) {
			return sprintf("'%04.4d-%02.2d-%02.2d %02.2d:%02.2d:%02.2d'",$_arrdt[3],$_arrdt[2],$_arrdt[1],$_arrdt[4],$_arrdt[5],$_arrdt[6]);
		}
		return false;
	}
	
	public function converteDataToHTML($_data) {
		// $_data Sempre no formato YYYY-MM-DD
		if(ereg("^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}).*$",$_data,$_arrdt)!==false) {
			return sprintf("%02.2d-%02.2d-%04.4d",$_arrdt[3],$_arrdt[2],$_arrdt[1]);
		}
		return $_data; //false;
	}
	
	public function converteDataHoraToHTML($_dtime) {
		// $_dtime Sempre no formato YYYY-MM-DD HH:MM:SS
		if(ereg("^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})[[:space:]]([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}).*$",$_dtime,$_arrdt)!==false) {
			return sprintf("%02.2d-%02.2d-%04.4d %02.2d:%02.2d:%02.2d",$_arrdt[3],$_arrdt[2],$_arrdt[1],$_arrdt[4],$_arrdt[5],$_arrdt[6]);
		}
		return $_dtime; //false;
	}
}

/**
 * ORACLE

class oracle extends BancoDados {
	public function __construct() {
		$this->_Tipo = 'oracle';
	}
	
	public function Conectar() {
		//oci_connect  ( string $username  , string $password  [, string $db  [, string $charset  [, int $session_mode  ]]] )
		if(($this->_conn=@oci_connect($this->_Usuario,$this->_Senha,$this->_Banco,"american.we8iso8859p1"))===false) {
			$_e = oci_error();
			$this->_ultimoerro = "Erro na Conexão com o Banco de Dados : {$_e['message']}";
		}
		return $this->_conn;
	}
}
 */


/**
 * Classe para gerenciamento do banco de dados PostgreSQL (pgsql)
 *
 */
class pgsql extends BancoDados {
	
	public function __construct() {
		$this->_Tipo = 'pgsql';
	}
	
	protected function SetNumRows() {
		$this->_numrows = ($this->_dataset!==false ? pg_num_rows($this->_dataset) : 0);
	}
	
	public function Conectar() {
		$_strcon = "host={$this->_Servidor} ";
		$_strcon.= "dbname={$this->_Banco} ";
		$_strcon.= "user={$this->_Usuario} ";
		if($this->_Senha!=NULL&&$this->_Senha!="") {
			$_strcon.= "password={$this->_Senha} ";
		}
		if(is_int($this->_Porta)) {
			$_strcon.= "port={$this->_Porta}";
		}
		if(($this->_conn = @pg_connect($_strcon))===false) {
			$_e = error_get_last();
			$this->_ultimoerro = "Erro na Conexão com o Banco de Dados : {$_e['message']}";
		}
		return $this->_conn;
	}
		
	public function executaSQL($_sql) {
		if($this->_conn!==false) {
			if(($_res=@pg_query($this->_conn,$_sql))===false) {
				$this->_ultimoerro = "Erro ao Executar o comando {$_sql} : " . pg_last_error();
			} else {
				$this->isSELECT($_sql,$_res);
			}
			return $_res;
		} else {
			return false;
		}
	}
	
	protected function navegainterno($_pos) {
		if(pg_result_seek($this->_dataset,$_pos)!==false) {
			$this->_tupla = pg_fetch_assoc($this->_dataset);
		}
	}
	
	protected function proximointerno() {
		$this->_tupla = pg_fetch_assoc($this->_dataset);
	}
	
	public function escapeString($_str) {
		return pg_escape_string($this->_conn,$_str);
	}
	
	public function getLimit($_arr) {
		return " {$_arr['LIMIT']} OFFSET {$_arr['OFFSET']}";
	}
	
	public function setAffectedRows() {
		$this->_numrows = ($this->_dataset!==false ? pg_affected_rows($this->_dataset) : 0);
	}
	
	public function multiqueries($_sql) {
		return $this->executaSQL($sql);
	}
	
}

/**
 * Classe para gerenciamento do banco de dados MySQL
 *
 */
class mysql extends BancoDados {
	
	public function __construct() {
		$this->_Tipo = 'mysql';
	}
	
	protected function SetNumRows() {
		$this->_numrows = ($this->_dataset!==false ? $this->_dataset->num_rows : 0);
	}
	
	public function Conectar() {
		if(($this->_conn = new mysqli($this->_Servidor,$this->_Usuario,$this->_Senha,$this->_Banco,$this->_Porta))===false) {
			$this->_ultimoerro = "Erro na Conexão com o Banco de Dados : " . mysqli_connect_error();
		}
		return $this->_conn;
	}
	
	public function executaSQL($_sql) {
		if($this->_conn!==false) {
			$_sql = str_replace('||','+',$_sql);
			if(($_res=@$this->_conn->query($_sql))===false) {
				$this->_ultimoerro = "Erro ao Executar o comando {$_sql} : " . $this->_conn->error;
			}
			$this->isSELECT($_sql,$_res);
			return $_res;
		} else {
			return false;
		}
	}
	
	protected function navegainterno($_pos) {
		if($this->_dataset!==false) {
			if($this->_dataset->data_seek($_pos)!==false) {
				$this->_tupla = $this->_dataset->fetch_assoc();
			}
		}
	}
	
	protected function proximointerno() {
		if($this->_dataset!==false) {
			if(($_row=$this->_dataset->fetch_row())===null) {
				$this->_tupla = false;
			} else {
				foreach($this->_dataset->fetch_fields() as $_pos=>$_campo) {
					$this->_tupla[$_campo->name] = $_row[$_pos];
				}
			}
			/*
			$this->_tupla = $this->_dataset->fetch_assoc();
			if($this->_tupla===null) {
				$this->_tupla = false;
			}
			*/
		}
	}

	public function escapeString($_str) {
		return $this->_conn->real_escape_string($_str);
	}
	
	public function getLimit($_arr) {
		return " {$_arr['OFFSET']},{$_arr['LIMIT']}";
	}

	public function setAffectedRows() {
		$this->_numrows = ($this->_dataset!==false ? $this->_conn->affected_rows : 0);
	}
	
	public function multiqueries($_sql) {
		return $this->_conn->multi_query($sql);
	}
	
}
?>