<?php

require '../initialization/dbconnection.php';
session_start();
$id=$_GET['id'];
global $mysqli;

$query="SELECT user from album where id='$id';";
$query.= "DELETE FROM album WHERE id='$id';";
if(!$mysqli->multi_query($query)){
    die($mysqli->error);
}
else{
    $result= $mysqli->store_result();
    $obj= $result->fetch_object();
    $user= $obj->user;
}
if(!$mysqli->next_result()){
    die($mysqli->error);
}
$mysqli->close();
header('Location: ../profiles/profile.php?user='. $user);
?>
