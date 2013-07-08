<?php
/*
	Autor: Walace Soares
	Livro: Construindo um Site B2C - da Concepção à programação
	Data:  21/01/2001
	
	Classe bd
		Propriedades:
			bd ->  Tipo do banco de dados 
			id ->  Indeitifcador da conexão com o BD
		Opeadores:
			+bd() -> Construtor
			+conecta() ->  Conecta o banco de dados desejado
			
	
	Classe consulta
		Propriedades:
			bd -> Tipo do BD
			id -> Identificador da conexão
			res -> Identificador do resultado da consulta
			row -> Linha atual
			nrw -> Total de linhas resultantes da consulta
			data -> Array com valores dos campos da linha atual

		Operadores:
			+consulta -> Construtor
			+executa -> Executa um comando SQL no BD
			+primeiro -> Busca a primeira linha da consulta
			+proximo -> Busca a próxima linha
			+anterior -> Busca a linha anterior a atual
			+ultimo -> via para a ultima linha da consulta
			+navega -> Busca uma linha especifica
			+dados -> Retorna os campos da linha atual
*/

class bd {

 var $bd;
 var $id;

 function bd($sgbd="postgresql") {
	$this->bd = $sgbd;
 }

 function conecta($bd,$servidor,$porta,$usuario,$senha) {
	if($this->bd=="postgresql") {
		$this->id = pg_connect($servidor,$porta,$usuario,$senha,$bd);
	}
	else {
		$this->id = mysql_connect($servidor,$usuario,$senha);
		if($this->id) {
			mysql_select_db($bd,$this->id);
		}
		else
			$this->id = 0;
	}

 }

}

class consulta {

 var $bd;
 var $res;
 var $row;
 var $nrw;
 var $data;

 function consulta(&$bd) {
	$this->bd = $bd;
 }

 function executa($sql="",$tipo="") {
	if($sql=="") {
		$this->res = 0;
		$this->nrw = 0;
		$this->row = -1;
	}
	if($this->bd->bd=="postgresql") {
		$this->res = pg_exec($this->bd->id,$sql);
		$this->nrw = pg_numrows($this->res);
	}
	else {
		$this->res = mysql_query($sql,$this->bd->id);
		$this->nrw = @mysql_num_rows($this->res);
	}

	// grava logfile
	if($tipo!="log") {
		$oper = substr($sql,0,6);
		$file = "";
		switch($oper) {
			case "INSERT":
				$file = substr($sql,12,strpos($sql,"VALUES")-12);
				break;
			case "UPDATE":
				$file = substr($sql,7,strpos($sql,"SET")-7);
				break;
			case "DELETE":
				$file = substr($sql,12,strlen($sql));
				break;
		}
		if(substr($file,0,6)=="pedido" OR substr($file,0,7)=="usuario") {
			$log = new logfile($this->bd);
			$log->operacao = htmlentities(addslashes($sql));
			$log->incluir();
			// Gera um email para o auditor do site
			if(substr($file,0,7)=="pedidos" OR substr($file,0,12)=="pedido_pagto") {
				$assunto = "Manutenção em pedidos";
				$mensagem = " DATA: " . date("d/m/Y",time()) . "\n\n";
				$mensagem.= "o seguinte comando SQL foi executado ";
				$mensagem.= "afetando a tabela de pedidos ou de dados financeiros\n\n";
				$mensagem.= $sql . "\n\n";
				$mensagem.= "Para maiores detalhes solicite a trilha de auditoria do site";
				$mensagem.= "(tabela logfile)\n\n";
				$mensagem.= "<<siteB2c - Sistema de Alerta>>";
				$dst = "walaces@uol.com.br";
				mail($dst,$assunto,$mensagem,"From: alerta@siteb2c.com.br");
			}
		}
	}
	
	$this->row = 0;
	if($this->nrw>0)
		$this->dados();
 }

 function primeiro() {
	$this->row = 0;
	$this->dados();
 }

 function proximo() {
	$this->row = ($this->row<($this->nrw-1))?++$this->row:($this->nrw - 1);
	$this->dados();
 }

 function anterior() {
	$this->row = ($this->row>0) ? --$this->row : 0;
	$this->dados();
 }

 function ultimo() {
	$this->row = $this->nrw-1;
	$this->dados();
 }

 function navega($linha) {
	if($linha>=0 AND $linha<$this->nrw) {
		$this->row = $linha;
		$this->dados();
	}
 }

 function dados() {
	if($this->bd->bd=="postgresql")
		$this->data = pg_fetch_array($this->res,$this->row);
	else {
		mysql_data_seek($this->res,$this->row);
		$this->data = mysql_fetch_array($this->res);
	}
 }
 
 function last_id($seq="",$sql="SELECT LAST_INSERT_ID()") {
	if($this->bd=="postgresql") { 
		$sql = "SELECT CURRVAL('$seq')";
		$this->executa($sql);
		if(!$this->res)
			return 0;
		return $this->data[0];
	}
	else {
		$this->executa($sql);
		return $this->data[0];
	}
  }

}  

echo "<pre>";
Reflection::export(new ReflectionClass('bd'));
Reflection::export(new ReflectionClass('consulta'));
echo "</pre>";


?>
