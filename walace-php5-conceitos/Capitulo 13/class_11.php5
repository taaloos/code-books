<?php
  class contador {
  	const _INICIO = 0;						  
	const _FIM = 999;
	private static $_cont = contador::_INICIO;
	
	public static function contar() {
		self::$_cont++;
		if(self::$_cont>self::_FIM) {
		  self::$_cont=self::_INICIO;
		  return "_FIM_";
		}
		else {
		  return self::$_cont;
		}
	} 
  }
  
  for($_i=0;$_i<1005;$_i++) {
    echo contador::contar() . ", ";
  }
?>