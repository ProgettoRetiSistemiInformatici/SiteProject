<?php
$tag = $_SESSION['tags'];
$photo_name = $_SESSION['photo'];

$query = "SELECT id FROM photo WHERE name = '$photo_name';";
if(!$result = $mysqli -> query($query)){
  echo "Errore nella query per prendere l'id";
}
$photo_id = $result;


$tags = explode(" ", $tag);
/*
* Questo controllo al suo interno avrà una query
* per ogni tabella in cui andranno inseriti i tag
*/
foreach ($tags as $value){
  //fai la query dove controlli se esiste già nel DB dei tags altrimenti lo inserisci.
  $query = "SELECT tag, photos_id FROM tags WHERE tag = '$value';";
  if(!$result = $mysqli -> query($query)){
    echo "Errore nella query per ottenere i tags";
  }
  echo "</br>";
  var_dump($result -> num_rows);
  echo "</br>";
  $rows = $result -> num_rows;
  echo $rows . "</br>";
  if($rows){
    $obj = $result -> fetch_object();
    $photo_id .= " " . $obj->photos_id;
    $query = "UPDATE tags SET photos_id = '$photo_id' WHERE tag = '$value';";
    if(!$result = $mysqli -> query($query)){
      echo "Errore nella query per aggiornare i tags";
    }
    echo "Tag " . $value . " non inserito";
  }
  else {
    $query = "INSERT INTO tags (tag, photos_id) VALUES ('$value', '$photo_id');";
    //NOTA: questo inserimento va fatto solo DOPO aver inserito la foto nel DB
    if(!$result = $mysqli ->  query($query)){
      echo "Errore nella seconda query per inserire i tags";
    }

    echo "Tag " . $value . " inserito";
  }
}

?>
