<?php
include 'dbconnection.php';

session_start();


$newBirth = $_POST['newBirth'];
$Birthsql = date('Y-m-d',$newBirth);
$newFirstName = $_POST['newName'];
$newLastName = $_POST['newLName'];
$profileId=$_SESSION['profile']->id;

global $mysqli;
if(!$mysqli->query("UPDATE users SET firstname ='$newFirstName', lastname='$newLastName', birth='$Birthsql' WHERE id='$profileId';")){
    die($mysqli->error);
    $error = "error in mysql!";
}
header("Location: profile.php?user=".$_SESSION['profile']->user);

session_write_close();

?>
