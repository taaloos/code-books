<?php
	function debug() {
 		echo '<pre>';
 	 	$_trc = debug_backtrace();
  		array_shift($_trc);
  		foreach($_trc as $arr)  {
			echo "Função: ";
      		if (isset($arr['class'])) echo $arr['class'] . '->';
      		$args = array();
      		if(!empty($arr['args'])) { 
				foreach($arr['args'] as $v) {
          				if (is_null($v)) {
						$args[] = 'Null';
					} elseif(is_array($v)) {
						$args[] = 'Array('  .  implode($v,",") . ')';
					} elseif(is_object($v)) {
						$args[] = 'Objeto: ' . get_class($v);
					} elseif (is_bool($v)) {
						$args[] = 'Bool: ' . ($v ? 'V(TRUE)' : 'F(FALSE)');
					} else { 
              				$v = (string) $v;
              				$str = htmlspecialchars($v);
              				$args[] = "\"".$str."\"";
          				}
				}
      		}
      		echo  $arr['function'] . '(' .  implode(', ',$args) . ')<br/>';
      		$_l = (isset($arr['line']) ?  $arr['line'] : "-");
      		$_f = (isset($arr['file']) ?  $arr['file'] : "-");
      		echo  "Linha $_l , Arquivo: $_f";
      		echo "<br/>";
  		}    
  		echo '</pre>';
	}
	
	function teste_debug($str,$tipo) {
		debug();
	}
	
	teste_debug("Walace",Array('TESTE',10,20,35.5));
?>
