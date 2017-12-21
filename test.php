<?php
  require 'initialization/dbconnection.php';
  $array = array();
  $query = "SELECT id FROM comments;";
  while($result = $mysqli->query($query)){

    $array[] = $result;
    var_dump($array);
  }

?>
