<?php

require '../initialization/dbconnection.php';

if(!empty($_POST['albums'])){

  //se non si e' loggati si viene reindirizzati nella pagina di registrazione/login
  if(!isset($_SESSION["current_user"])){
    header("Location: /index.php");
  }

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
  $query = "SELECT name FROM photo WHERE id IN ('$ids');";
  $query .= "DELETE FROM photo WHERE id IN ('$ids') AND user_id = '$user';";
  if($mysqli->multi_query($query)){

    $photo_names = $mysqli->store_result();

    while($p_name = $photo_names->fetch_object()){
      $path = '../uploads/' . $p_name->name;
      unlink($path);
    }

    if($mysqli->next_result()){
      $delete = $mysqli->store_result();
    }
    else{
      die($mysqli->error);
    }
  }

  header("Location: ../gallery/index_photos.php?user=". $user);
  exit();
}

?>
