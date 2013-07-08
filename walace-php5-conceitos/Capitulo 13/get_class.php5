<?php
class bd {
		public $bd;
		public $id;
		function __construct($sgbd="postgresql") {
		$this->bd = $sgbd;
		}
	public function ShowName() {
		echo "Nome da Classe: " . get_class($this) ;
	}
	public function conecta($bd,$srv,$prt,$usr,$snh) {
		if($this->bd=="postgresql") {
			$this->id = pg_connect($srv,$prt,$usr,$snh,$bd);
		}
		else {
			$this->id = mysql_connect($srv,$usr,$snh);
			if($this->id) {
				mysql_select_db($bd,$this->id);
			}
			else {
				$this->id = 0;
			}
		}
	}
}

$_con = new bd("mysql");
$_con->ShowName();
echo "<br/>";
echo "Classe : " . get_class($_con);
?>
