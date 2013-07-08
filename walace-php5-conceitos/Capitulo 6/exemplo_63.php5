<?php
    $arr = array(10,15,23,56,101,205);
   	foreach($arr as $vlr) {
		echo "$vlr <br>";
	}

	$arr_2 = array(
				"um" => "one",
				"dois" => "two",
				"três" => "three",
				"quatro" => "four",
				"cinco" => "five");
	foreach($arr_2 as $chv => $vlr) {
		echo "$chv  = $vlr <br>";
	}
?>

<?php
		$arr3[0][0] = 10;
		$arr3[0][1] = 50;
		$arr3[1][0] = 12;
		$arr3[1][1] = 23;
		$arr3[1][3] = 35;
		$arr3[2][1] = 10;
		foreach($arr3 as $chv => $vlr) {
			foreach($vlr as $chv_1 => $vlr_1) {
		 		echo "\$arr[$chv][$chv_1] = $vlr_1 <br>";
			}
		}
?>

