<?php
	$_arr = Array("Nome 5"=>"Walace",
						"Nome 3"=>"Mara",
						"Nome 1"=>"Carol",
						"Nome 4"=>"Isabelle",
						"Nome 2"=>"Ivanilza");
	$_k1 = each($_arr);
	echo "<pre>";
	print_r($_k1);
	$_k1 = each($_arr);
	print_r($_k1);
	echo "</pre>";
?>

<?php
   function converte_xml($_tag,$_var,$_lvl=0)  {
	 for($i=0;$i<$_lvl;$i++)  {
		$_mrg.=' ';
	 }
	 if (eregi('^[0-9].*$',$_tag)) {
	 	$_tag='tag_'.$_tag;
	 }
	 if (is_array($_var))  {
	 	$_res .=  $_mrg. str_repeat(" ",$_lvl*3) . "<$_tag>\n";
  		while (list ($_k, $_v) = each ($_var))   {
		   $_res .= converte_xml($_k,$_v,$_lvl+1);
		}
		$_res .=  $_mrg . str_repeat(" ",$_lvl*3) . "</$_tag>\n";
	 }
	 elseif (strlen($_var)>0)  {
	 	$_res .= $_mrg . str_repeat(" ",$_lvl*3) . "<$_tag>" . 																			
			  	 htmlspecialchars($_var) . 
				 "</$_tag>\n";
	 } 
	 return $_res;
   }

   $_arr = Array("name"=>"Walace", 
   		   		 "Idade"=>"37",
				 "Filhos"=> Array("Carol",
				 				  "Isabelle")
				);
   echo converte_xml("TESTE_XML",$_arr);
?> 
