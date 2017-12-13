<?php
$tag = $_SESSION['tags'];
$photo = $_SESSION['photo'];

$tags = explode(" ", $tag);
/*
* Questo controllo al suo interno avrà una query
* per ogni tabella in cui andranno inseriti i tag
*/
foreach ($tags as $value){
  //fai la query dove controlli se esiste già nel DB dei tags altrimenti lo inserisci.
  $query = "SELECT tag, photo FROM tags WHERE tag = '$value';";
  if(!$result = $mysqli -> query($query)){
    echo "Errore nella query";
  }
  echo "</br>";
  var_dump($result -> num_rows);
  echo "</br>";
  $rows = $result -> num_rows;
  echo $rows . "</br>";
  if($rows){
    $obj = $result -> fetch_object();
    $photo .= " " . $obj->photo;
    $query = "UPDATE tags SET photo = '$photo' WHERE tag = '$value';";
    if(!$result = $mysqli -> query($query)){
      echo "Errore nella query";
    }
    echo "Tag " . $value . " non inserito";
  }
  else {
    $query = "INSERT INTO tags (tag, photo) VALUES ('$value', '$photo');";
    //NOTA: questo inserimento va fatto solo DOPO aver inserito la foto nel DB
    if(!$result = $mysqli ->  query($query)){
      echo "Errore nella seconda query";
    }

    echo "Tag " . $value . " inserito";
  }
}

?>
