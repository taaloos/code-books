<?php
	$_con = @mysql_connect("localhost","root","");
	if($_con===FALSE) {
		echo "- foi possivel conectar ao MySQL " . 
				mysql_error();
		exit;
	}		 
	
	mysql_select_db("BD_PHP5",$_con);
	if($_con===FALSE) {
		echo "- foi possivel conectar ao Banco de Dados " . 
				mysql_error();
		exit;
	}
	
	
	// finalmente vamos listar os registros existentes no Banco
	$_sql = "SELECT * FROM Usuario";
	$_res = mysql_query($_sql,$_con);
	if($_res===FALSE) {
		echo "Erro na consulta... " . mysql_error() . "<br/>";
	} else {				  
		$_nr = mysql_num_rows($_res);
		if($_nr>0) {
			// Primeiro o cabeçalho com os campos da tabela
			echo "<table border=1 cellspacing=3 cellpadding=2>"; 
			echo "<tr bgcolor='#f0f0f0'>
				  	<td>Nome</td>
					<td>Tabela</td>
					<td>Tipo</td>
					<td>Tamanho Máximo</td>
					<td>Chave Primária</td>
					<td>Chave única</td>
					<td>Chave</td>
					<td>Not NULL</td>
					<td>Numérico</td>
					<td>Sem Sinal</td>
					<td>ZeroFILL</td>
					<td>BLOB</td>
				  </tr>";
			for($_i=0;$_i<mysql_num_fields($_res);$_i++) {
				echo "<tr>";
				echo "<td>" . mysql_field_name($_res,$_i) . "</td>";
				// Dados do campo...
				$_f = mysql_fetch_field($_res,$_i);
   				echo   "<td>$_f->table</td>
						<td>$_f->type</td>
						<td>$_f->max_length</td>
						<td>" . ($_f->primary_key==1 ? "*" : "-") . "</td>" .
						"<td>" . ($_f->unique_key==1 ? "*" : "-") . "</td>" .
						"<td>" . ($_f->multiple_key==1 ? "*" : "-") . "</td>" .
						"<td>" . ($_f->not_null==1 ? "*" : "-") . "</td>" .
						"<td>" . ($_f->numeric==1 ? "*" : "-") . "</td>" .
						"<td>" . ($_f->unsigned==1 ? "*" : "-") . "</td>" .
						"<td>" . ($_f->zerofill==1 ? "*" : "-") . "</td>" .
						"<td>" . ($_f->blob==1 ? "*" : "-") . "</td>" .
					"</tr>";
			}
			echo "</table>";
		}
	}																			  
	
	mysql_close($_con);
	
?>
