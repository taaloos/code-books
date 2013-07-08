<?php //sample8_2.php ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Sample 8_2</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="xmlhttp.js"></script>
<script type="text/javascript" src="functions.js"></script>
</head>
<body>
	<?php
	
		//Max Rows.
		$maxrows = 3;
		//Max Cols.
		$maxcols = 4;
	
		//Load in the HTML_Table PEAR module.
		require_once ("HTML/Table.php");
		//Create a table instance.
		$table =& new HTML_Table ('cellpadding="0",cellspacing="0",border="1",class="tablehead"');
		//Set the caption of the table.
		$table->setCaption ("HTML_Table use with AJAX");
				
		//Create our data set of empty rows.
		$counter = 0;
		for ($i = 0; $i < $maxrows; $i++){
			for ($j = 0; $j < $maxcols; $j++){
				$counter++;
				$table->setCellAttributes($i, $j, array('height' => '20', 'onclick' => 'createtext(this,' . $j . ',' . $counter . ',' . $maxcols . ',' . $maxrows . ');', 'width' => '25%','bgcolor' => '#FFFFFF', 'align' => 'center'));
			}
		}
		
		//Create a "totals" separator.
		$totdata = array ("Totals");
		$table->addRow($totdata,array ('colspan' => '4', 'bgcolor' => '#0000FF', 'style' => 'text-align: center; color: #FFFFFF;'));
		
		//Then create the totals boxes.
		$totcounter = 0;
		for ($i = $maxcols; $i < ($maxcols + 1); $i++){
			for ($j = 0; $j < $maxcols; $j++){
				$table->setCellAttributes($i, $j, array('id' => 'tot' . $totcounter . '','height' => '20', 'width' => '25%','bgcolor' => '#EEEEEE', 'align' => 'center'));
				$totcounter++;
			}
		}
		
		echo $table->toHTML();
	?>
</body>
</html>