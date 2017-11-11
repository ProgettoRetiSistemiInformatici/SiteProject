<?php
include 'dbconnection.php';

session_start();


if(isset($_POST['newBirth'])){
    $newBirth = $_POST['newBirth'];
    $Birthsql = date('Y-m-d',$newBirth);
}
else {
    $Birthsql=$_SESSION['profile']->birth;
}
if(isset($_POST['newName'])){
    $newFirstName = $_POST['newName'];
}
else{
    $newFirstName=$_SESSION['profile']->firstname;
}
if(isset($_POST['newLName'])){
    $newLastName = $_POST['newLName'];
}
else{
    $newLastName = $_SESSION['profile']->lastname;
}
$profileId=$_SESSION['profile']->id;

global $mysqli;
if(!$mysqli->query("UPDATE users SET firstname ='$newFirstName', lastname='$newLastName', birth='$Birthsql' WHERE id='$profileId';")){
    die($mysqli->error);
    $error = "error in mysql!";
}
header("Location: profile.php?user=".$_SESSION['profile']->user);

session_write_close();

?>
