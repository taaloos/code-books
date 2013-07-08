<pre>
<?php
	$texto = "PHP";
	echo str_pad($texto,10) . "!";
	echo "<br>";
	echo 	str_pad($texto,20,"_");
	echo "<br>";
	echo str_pad($texto,20,"*_*-",STR_PAD_BOTH);
?>
</pre>
