<?php

require '../initialization/dbconnection.php';

//se non si e' loggati si viene reindirizzati nella pagina di registrazione/login
if(!isset($_SESSION["current_user"])){
    header("Location: /index.php");
}

$galleryitems = $_POST['galleryitem'];
$title = $_POST['title'];
$cover = $_POST['cover'];

$user = $_SESSION['current_user'];

$query = "INSERT INTO albums (title, user_id, cover) VALUES ('$title','$user','$cover')";
if(!$mysqli->query($query)){
    die($mysqli->error);
}

$items = new CachingIterator(new ArrayIterator($galleryitems));
$album_id = $mysqli->insert_id;
$values = "";
foreach ($items as $photo_id){
  $values .= "($album_id, $photo_id)";
  if($items->hasNext()){
    $values .= ",";
  }
  else{
    $query = "INSERT INTO contents(album_id, photo_id) VALUES $values;";
    if(!$mysqli->query($query)){
      die($mysqli->error);
    }
  }
}

header("Location: ../gallery/index_albums.php?user=". $user);
exit();

?>
