<?php
	$_arq = "geometria.pdf";
	header("Content-Description: File Transfer");
	header("Content-Type: application/force-download");
	header("Content-Disposition: attachment; filename=".basename($_arq));
	@readfile($_arq);
?> 
