<?php
	class imagem {
		protected $_img;
		protected $_tipo;

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
					default:		$_img = FALSE;
				}
			} else {
				$_img = FALSE;
			}
			if(!$_img) {
			   	// Erro na carga da imagem
			   	$_img = imagecreate(150,100);
			   	$_prt = imagecolorallocate($_img, 0,0,0); 
				$_cza = imagecolorallocate($_img, 204,204,204);
				$_vrm = imagecolorallocate($_img, 255,0,0); 
				imagefilledrectangle($_img,0,0,149,99,$_cza);
				imagerectangle($_img,0,0,149,99,$_prt);
				imagerectangle($_img,3,3,15,15,$_vrm);
				imageline($_img,4,4,14,14,$_vrm);
				imageline($_img,4,14,14,4,$_vrm);
				imagestring($_img,2,22,4,$_arq,$_prt);
				imagestring($_img,5,50,40,"IMAGEM",$_vrm);
				imagestring($_img,5,15,60,"NÃO ENCONTRADA",$_vrm);				
			}
			$this->_img = $_img;
		}
		
		public function mostra_imagem() {
			if($this->_img!=NULL) {
				header("Content-type: image/png");
				imagepng($this->_img);			
			}
		}
	}
	
	$_i = new imagem();
	$_i->getImagem("Bola.jpg");	 
	$_i->mostra_imagem();
?>


