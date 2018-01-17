<?php

require '../initialization/dbconnection.php';

session_start();

global $mysqli;
$ids = $_SESSION['ids'];
$user = $_SESSION['current_user'];
$cover =$_SESSION['cover'];
$title = $_SESSION['title'];
$query="INSERT INTO albums (title, user_id, photos_id, cover) VALUES ('$title','$user','$ids','$cover')";
if(!$mysqli->query($query)){
    die($mysqli->error);
}
header("Location: ../profiles/profile.php?user=". $user);
exit();

?>
