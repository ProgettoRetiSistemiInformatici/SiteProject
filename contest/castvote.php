<?php
require '../initialization/dbconnection.php';
$photo_id = $_GET['photo'];
$redirectcto = $_SESSION['contest_id'];
$query = "UPDATE photo SET votes = votes+1 WHERE id ='$photo_id'";
if(!$mysqli->query($query)){
    die($mysqli->error);
}
$mysqli->close();
?>