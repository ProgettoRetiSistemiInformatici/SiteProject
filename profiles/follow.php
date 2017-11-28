<?php

include("../dbconnection.php");
session_start();

global $mysqli;
$utente =$_SESSION['utente'];
$iduser2 = $_SESSION['otherprofile']->id;
$query = "Select id from users where name ='$utente';";
if(!$result = $mysqli->query($query)){
    die($mysqli->error);    
}
$obj = $result ->fetch_object();
$iduser1 =  $obj->id;
$query1 = "insert into relations (idUser1,idUser2,followship) values('$iduser1','$iduser2','1');";
if(!$ins = $mysqli-> query($query1)){
    die($mysqli->error);    
}
$mysqli->close();
session_write_close();

header('Location: ../home.php?user='. $utente);
?>
