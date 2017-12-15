<?php

require '../initialization/dbconnection.php';

session_start();

global $mysqli;
$ids = $_SESSION['ids'];
$user = $_SESSION['utente'];
$cover =$_SESSION['cover'];
$title = $_SESSION['title'];
$query="INSERT INTO albums (title, user, idPhoto, cover) VALUES ('$title','$user','$ids','$cover')";
if(!$mysqli->query($query)){
    die($mysqli->error);
}
header("Location: ../profiles/profile.php?user=". $user);
exit();

?>
