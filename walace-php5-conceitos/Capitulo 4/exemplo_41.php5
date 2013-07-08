<?php
  define("VALOR",10);
  define("FRUTA","Manga",True);
  echo "Fruta = " . fruta; // ou Fruta ou FRUTA 
  echo "Valor = " . VALOR; // Ok
  echo "Valor = " . Valor; // Não irá funcionar
  define("VALOR",990); // Provocará um erro
?>

