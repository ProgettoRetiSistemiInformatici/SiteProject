<?php

require '../initialization/dbconnection.php';

//se non si e' loggati si viene reindirizzati nella pagina di registrazione/login
if(!isset($_SESSION["current_user"])){
    header("Location: /index.php");
}

$galleryitems = $_POST['galleryitem'];
$title = $_POST['title'];
$cover = $_POST['cover'];
$final;

$ids = implode(" ", $galleryitems);

$user = $_SESSION['current_user'];

$query="INSERT INTO albums (title, user_id, photos_id, cover) VALUES ('$title','$user','$ids','$cover')";
if(!$mysqli->query($query)){
    die($mysqli->error);
}
header("Location: ../gallery/index_albums.php?user=". $user);
exit();

?>
