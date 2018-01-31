<?php

require '../initialization/dbconnection.php';
if(!empty($_POST['albums'])){

  $albums = $_POST['albums'];
  $ids = implode(", ", $albums);

  $user = $_SESSION['current_user'];

  $query="DELETE FROM albums WHERE id IN ('$ids') AND user_id = '$user';";
  if(!$mysqli->query($query)){
      die($mysqli->error);
  }
  header("Location: ../gallery/index_albums.php?user=". $user);
  exit();
}
else{
  $photos = $_POST['photos'];
  $ids = implode(", ", $photos);

  $user = $_SESSION['current_user'];

  $query="DELETE FROM photo WHERE id IN ('$ids') AND user_id = '$user';";
  if(!$mysqli->query($query)){
      die($mysqli->error);
  }
  header("Location: ../gallery/index_photos.php?user=". $user);
  exit();
}

?>
