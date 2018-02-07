<?php

require "../initialization/dbconnection.php";

$followed_id = $_POST['user'];
$follower_id = $_POST['current_user'];

$query = "DELETE FROM relations WHERE (follower_id ='$follower_id' && followed_id='$followed_id');";
if(!$ins = $mysqli-> query($query)){
    die($mysqli->error);
}

$mysqli->close();
session_write_close();

?>
