<?php

//se non si e' loggati si viene reindirizzati nella pagina di registrazione/login
if(!isset($_SESSION["current_user"])){
    header("Location: /index.php");
}

$current_user = $_SESSION['current_user'];
$tags = $_SESSION['tags'];
$photo_id = $_SESSION['photo_id'];

$tags = explode("#", $tags);
/*
* Questo ciclo al suo interno avrà una query
* per ogni tabella in cui andranno inseriti i tag
*/
foreach ($tags as $value){
  $value = trim($value);
  if($value == ""){
    continue;
  }
  //fai la query dove controlli se esiste già nel DB dei tags altrimenti lo inserisci.
  $query = "SELECT id FROM tags WHERE tag = '$value';";
  if(!$result = $mysqli -> query($query)){
    echo "Errore nella query per ottenere l'id del tag";
  }
  $rows = $result->num_rows;
  if($rows){
    $obj = $result->fetch_object();
    $query = "INSERT INTO tag_reference(tag_id, photo_id, user_id) VALUES ('$obj->id', '$photo_id', '$current_user');";
    if(!$result = $mysqli -> query($query)){
      echo "Errore nella query per aggiornare i tags";
    }
    echo "Tag " . $value . " non inserito";
  }
  else {
    $query = "INSERT INTO tags (tag) VALUES ('$value');";
    if(!$result = $mysqli ->  query($query)){
      echo "Errore nella query per inserire i tags";
    }
    echo "Tag " . $value . " inserito";
    $tag_id = $mysqli->insert_id;
    $query = "INSERT INTO tag_reference(tag_id, photo_id, user_id) VALUES ('$tag_id', '$photo_id', '$current_user');";
    if(!$result = $mysqli ->  query($query)){
      echo "Errore nella query per inserire il riferimento alla tabella dei tags";
    }
    echo "Riferimento inserito";
  }
}

?>
