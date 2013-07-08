<?php
	 function _Log() {
       $arq = fopen('c:\\tmp\\auditoria.log', 'a');
       fwrite($arq, sprintf("[%s ] %s ; %s\n",
                           date('d-m-Y H:i:s', time()),
                           $_SERVER['PHP_SELF'],
                           $_SERVER['REMOTE_ADDR']));
       fclose($arq);
	 }

	 register_shutdown_function('_Log');
?>
