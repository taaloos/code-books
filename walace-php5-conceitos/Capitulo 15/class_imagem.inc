<?php
class imagem {
	public $_img;
	protected $_tipo;
	protected $_cores;

	public function novaImagem($_w,$_h) {
		$this->_img = imagecreatetruecolor($_w,$_h);
		$this->_tipo = "png";
	} 
	
	public function getImagem($_arq) {
		$_p = strrpos($_arq,".");
		$this->_tipo = trim(strtolower(substr($_arq,$_p+1,4)));					
		if(file_exists($_arq)) {
			switch($this->_tipo) {
				case 'png': 	$_img = @imagecreatefrompng($_arq);
								break;
				case 'jpg':
				case 'jpeg':	$_img = @imagecreatefromjpeg($_arq);
								break;
				case 'xpm':		$_img = @imagecreatefromxpm($_arq);
								break;
				default:		return FALSE;
			}
		} else {
			return FALSE;
		}
		$this->_img = $_img;
	}

	public function alocaCor($_nome="",$_cor=Array(0,0,0)) {
		if($_nome!="") {
			$this->_cores[$_nome] = imagecolorallocate($this->_img,$_cor[0],$_cor[1],$_cor[2]);
			return TRUE;
		} else {
			$_ret =	$this->_cores[]=imagecolorallocate($this->_img,$_cor[0],$_cor[1],$_cor[2]);
			return $_ret;
		}
	} 
	
	public function getCor($_cor) {
		return $this->_cores[$_cor];
	}
	
	public function mostra() {
		if($this->_img!=NULL) {
			header("Content-type: image/png");
			imagepng($this->_img);			
		}
	}
	public function salva($_arquivo, $_tipo="png") {
		if($this->_img<>NULL) {
			switch($_tipo) {
				case 'png': 	imagepng($this->_img,$_arquivo);					
								break;
				case 'jpg':	
				case 'jpeg':	imagejpeg($this->_img,$_arquivo);
								break;
			}
		}
	}
	public function destroi() {
		imagedestroy($this->_img);
		$this->_img = NULL;
	}	
}
?>
