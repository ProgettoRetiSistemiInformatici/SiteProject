<?php
session_start();
require '../initialization/dbconnection.php';
$user = $_SESSION['current_user'];
$gid = $_GET['group'];
$query = "DELETE from membership where group_id='$gid' and member_id='$user';";
$mysqli->query($query);
header('Location: ../profiles/profile.php?user='.$user);
?>