<?php

include("../dbconnection.php");

session_start();

global $mysqli;
$ids = $_SESSION['ids'];
$user= $_SESSION['utente'];
$cover=$_SESSION['cover'];
$titolo = $_SESSION['titlealbum'];
$query="INSERT into album (titolo,user,idFoto, cover) values('$titolo','$user','$ids','$cover')";
if(!$mysqli->query($query)){
    die($mysqli->error);
}
header("Location: /profiles/profile.php?user=". $user);
exit();


?>
