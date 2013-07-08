<?php
/**
 * Função Fatorial 
 * Onde Fatorial(n) = n * Fatorial(n-1), se n<=1, Fatorial(n)=1
 * Não existe Fatorial de números negativos (n<0)
 * @return		int
*/	 
function fatorial($_num) {
		if($_num<0) {
			return FALSE;
		}
		elseif($_num<=1) {
			return 1;
		}
		return $_num * fatorial($_num-1);
}

$_f = new ReflectionFunction('fatorial'); 
// Mostra o nome da Função e sua Documentação
echo "Função : " . $_f->getName() . "<br/>";
	"Declarada no Arquivo:  " . $_f->getFileName();
echo "Documentação:<pre>" . $_f->getDocComment() . "</pre><br/>";

// O método export mostra todos os dados da função
echo "<pre><b>Utilizando ReflectionFunction::export</b>\n";
echo ReflectionFunction::export('fatorial');
echo "</pre>";
?>
