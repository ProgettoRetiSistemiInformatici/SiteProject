<?php
  require 'initialization/dbconnection.php';
  $array = array();
  $query = "SELECT id FROM photo WHERE id = '1';";
  if(!$result = $mysqli->query($query)){
    echo ("errore nella query");
  }
  var_dump($result->fetch_object());
?>
