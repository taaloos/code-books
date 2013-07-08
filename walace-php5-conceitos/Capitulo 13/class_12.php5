<?php
class bd {
		public $bd;
		public $id;
		function __construct($sgbd="postgresql") {
		$this->bd = $sgbd;
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

$_rm = new ReflectionMethod('bd','conecta');
echo " Método " . $_rm->getName()  . "<br/>";
echo "Tipo: " . ($_rm->isAbstract() ? ' abstato ' : ' ') . 
  					($_rm->isFinal() ? ' final ' : ' ') . 
  					($_rm->isPublic() ? ' publico ' : ' ') . 
  					($_rm->isPrivate() ? ' privativo ' : ' ') . 
  					($_rm->isProtected() ? ' protegido ' : ' ') . 
  					($_rm->isStatic() ? ' Estatico ' : ' ') . "<br/>";
//echo "Seu Retorno é do tipo:  " .   var_dump($_rm->invoke(new bd('mysql')));
echo "<pre>";
echo ReflectionMethod::export('bd','conecta');
echo "</pre>";
?>
