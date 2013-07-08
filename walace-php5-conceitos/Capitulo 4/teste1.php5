<?php
	$dia = date("d");
	$mes = date("m");
	$ano = date("Y");
 	printf("%04d-%02d-%02d", $ano, $mes, $dia);
	$vlr = 1235.50; 
	$vlr2 = 502.23;
	$sld = $vlr - $vlr2;
	printf("<br>%01.2f", $sld);
	echo "<br>";  
	echo 127 | 255;
	echo "<br>";  
	echo 10 << 2;
	echo "<br>";  
	echo 120 >> 1;
	echo "<br>";  
	echo 121 >> 1;
?>
	<?php
		$valor = 127;
		echo "<pre>";
		echo "Operador &: " . ($valor & 64) . "\n";
		echo "Operador | : " . ($valor | 255) . "\n";
		echo "Operador ^: " . ($valor ^ 21) . "\n";
		echo "Operador ~: " . (~$valor) . "\n";
		echo "Operador <<:" . ($valor << 5) . "\n";
		echo "Operador >>:" . ($valor >> 3) . "\n";
		echo "Operador & (String): " . ("PHP5" & "MYSQL");
		echo `winword.exe`;
		$v = 10;
		$a = ++$v;
		++$v;
		echo "$a   ::   $v";
		echo "</pre>";

		$arr1 = array("cidade" => "Vila Velha", "Livro" => "PHP5");
		$arr2 = array("cidade" => "São Paulo", "Data" => "Janeiro-2004");
		$arr4 = array(10,15,20);
		$arr5 = array(0,0,0,25,30,35);
		$arr3 = $arr1 + $arr2;
		$arr4 += $arr5;
		echo "<pre>";
		print_r($arr3);
		print_r($arr4);
	?>
<?php
$valor=1000.35; 
		if($valor<=15) {
			echo "Valor menor que 15";
		}
		elseif($valor<=100) {
			echo "Valor entre 15 e 100";
		}
		elseif($valor<=1000) {
			echo "Valor maior que 100 e menor ou igual a 1000";
		}
		else
			echo "Valor acima de 1000";
?>
<br>
<?php
		$i=10;
		while($i>0) {
			echo "$i ... ";
			$i--;
		}
echo "<br>";
		$k=10;
		do {
			echo "$k ... ";
			$k--;
		} while($k>0);
echo "<br>";
		
		while($i>0) {
		  echo "$i / ";
		  $i--;
		}
echo "<br>";
		
		do {
		  echo "$k / ";
		} while($k>0);
	?>

<?php
	echo "</pre>";
?>		

