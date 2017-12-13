<?php
  include 'dbconnection.php';

  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  $tags = $_SESSION['tags'];
  $user = $_SESSION['utente'];

  $query = "SELECT tags FROM users WHERE name = '$user';";
  if(!$result = $mysqli -> query($query)){
    echo "Errore nella query";
  }
  $num_rows = $result -> num_rows;
  //Controlla se ho già dei tags salvati
  if($num_rows > 0){
    $res = $result->fetch_object()->tags;
    $userTags = explode(" ", $res);
    $tags = explode(" ", $tags);

    $i = 0;
    $j = 0;

    foreach ($userTags as $value) {
      foreach($tags as $val){
        if($val == $value){
          global $i;
          $old[$i] = $value;
          $i = $i + 1;
          echo "Tag ". $value ." già presente";
        }
        else{
          $new[$j] = $value;
          $j = $j + 1;
        }
      }
    }
    $i = 10;
    $j = 0;
    $k = 0;
    global $old;
    $old_length = count($old);
    while ($i > 0){
        if($j < $old_length){
          global $i, $j;
          $array[$i--] = $old[$j++];
        }
        else {
          global $i, $k;
          $array[$i--] = $new[$k++];
        }
      }
      $array = implode(" ", $array);
  }
  else{ //Se non ho tags salvati
    $array = $tags;
  }
  //Controllo che la lunghezza dei nuovi tag da salvare non superi il valore nel DB
  while(strlen($array) > 200){
    $array = explode(" ", $array);
    $array[1] = null;
    $array = implode(" ", $array);
  }
  $query = "UPDATE users SET tags = '$array' WHERE name = '$user';";
  if(!$result = $mysqli -> query($query)){
    echo "Errore nella query";
  }

?>
