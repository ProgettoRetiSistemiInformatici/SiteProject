<?php

require "../initialization/dbconnection.php";

$followed_id = $_POST['user'];
$follower_id = $_POST['current_user'];

$query = "INSERT INTO relations (follower_id, followed_id) VALUES('$follower_id', '$followed_id');";
if(!$ins = $mysqli-> query($query)){
    die($mysqli->error);
}

$_SESSION['istr'] = true;
require '../shared/updateExp.php';

$mysqli->close();
session_write_close();

?>
