<?php
/*
Autor: Walace Soares
Livro: PHP5 
Data:  15/08//2004
Classe bd
Propriedades:
	bd ->  Tipo do banco de dados 
	id ->  Indeitifcador da conexão com o BD
Opeadores:
	+__construct -> Construtor
	+conecta() ->  Conecta o banco de dados desejado
*/
class bd {
	protected $bd;
	protected $id;
	
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
$_c = new ReflectionClass('bd');

echo "Classe: " . $_c->getName() . "<br/>";
echo "Definida no Arqivo: " . $_c->getFileName() .  " ( " . 
		$_c->getStartLine() . "," . $_c->getEndLine() . ")" . "<br/><br/>";
echo "Atributos:<br><pre>";
echo var_export($_c->getProperties(),1);
echo "</pre><br/>Métodos:<br/>";
echo "<pre>" . var_export($_c->getMethods(),1) . "</pre>";
// echo ReflectionClass::export('bd');
?>

