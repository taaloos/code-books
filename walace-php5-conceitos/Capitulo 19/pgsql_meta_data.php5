	<?php
	
		$_con = pg_connect("host=localhost dbname=BD_PHP5 user=usuario password=senha");  

	
		$_def = pg_meta_data($_con,"usuario");
		if($_def!==FALSE) {
			// Primeiro o cabeçalho com os campos da tabela
			echo "<table border=1 cellspacing=1 cellpadding=3>"; 
			echo "<tr bgcolor='#f0f0f0'>
				  	<td>Nome</td>
					<td>Posição</td>
					<td>Tipo</td>
					<td>Tamanho </td>
					<td>Not NULL?</td>
					<td>Tem valort padrão?</td>
				  </tr>";
			foreach($_def as $_f => $_d) {
				echo "<tr><td>$_f</td>";
				array_pop($_d);
				foreach($_d as  $_k=>$_vlr) {
					if($_k=="not null"||$_k=="has default") {
						echo "<td>" . ($_vlr ? "Sim" : "-") . "</td>";
					} else {
						echo "<td>$_vlr</td>"; 
					}
				}
				echo "</tr>";
			}
			echo "</table>";
		} else {
			echo "Erro...";
			var_dump($_def);
		}
		
		pg_close($_con);
	?>