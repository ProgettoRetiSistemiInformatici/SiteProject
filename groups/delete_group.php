<?php
session_start();

require '../initialization/dbconnection.php';
$user = $_SESSION['current_user'];
$gid = $_GET['group'];
$query = "DELETE from groups where id='$gid';";
if(!$mysqli->query($query)){
    die($mysqli->error);
}
header('Location: ../profiles/profile.php?user='.$user);
?>