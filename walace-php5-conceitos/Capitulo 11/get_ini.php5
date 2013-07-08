<?php
	function return_bytes($val) {
  		$val = trim($val);
  		$last = $val{strlen($val)-1};
		$_ret = 1;
  		switch($last) {
      		case 'm':
      		case 'M': 	$_ret = (int) $val * 1024;
      		case 'k':
      		case 'K': 		$_ret *= (int) $val * 1024;
          						break;
      		default:		$_ret = (int) $val;
  		}
		return $_ret;
	}
	function on_off($_valor) {
		return ($_valor==1  ?"ON" : "OFF");
	}
	echo 'display_errors = ' .  on_off(ini_get('display_errors')) .	"<br/>";
	echo 'register_globals = ' . on_off(ini_get('register_globals')). "<br/>";
	echo 'post_max_size = ' . ini_get('post_max_size') . "<br/>";
	echo 'post_max_size (em bytes) = ' . return_bytes(ini_get('post_max_size'));
?>
