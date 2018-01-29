<?php

require "../initialization/dbconnection.php";

session_start();

$followed_id = $_GET['flwd'];

global $mysqli;
$follower_id = $_SESSION['current_user'];

$query = "INSERT INTO relations (follower_id, followed_id) VALUES('$follower_id', '$followed_id');";
if(!$ins = $mysqli-> query($query)){
    die($mysqli->error);
}

$_SESSION['istr'] = true;
require '../shared/updatExp.php';

$mysqli->close();
session_write_close();

header('Location: profile.php?user='. $followed_id);

?>
