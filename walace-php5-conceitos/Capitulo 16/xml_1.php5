<?php
  $_xml = simplexml_load_file('exemplo.xml');
  echo "<pre>";
  var_dump($_xml);
  foreach($_xml->attributes() as $k=>$v) {
    echo "$k = $v<br>";
  }
  echo $_xml['version'];
  echo "</pre>";
?>
 