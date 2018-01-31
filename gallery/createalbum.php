<?php

require '../initialization/dbconnection.php';

$galleryitems = $_POST['galleryitem'];
$title = $_POST['title'];
$cover = $_POST['cover'];
$final;

$ids = implode("|", $galleryitems);
$ids = $ids . "|";

$user = $_SESSION['current_user'];

$query="INSERT INTO albums (title, user_id, photos_id, cover) VALUES ('$title','$user','$ids','$cover')";
if(!$mysqli->query($query)){
    die($mysqli->error);
}
header("Location: ../profiles/profile.php?user=". $user);
exit();

?>
