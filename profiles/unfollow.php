<?php

require '../initialization/dbconnection.php';

session_start();
global $mysqli;

$utente = $_SESSION['utente'];
$idUser2 = $_SESSION['otherprofile']->id;
$query = "Select id from users where name ='$utente';";
if(!$result = $mysqli->query($query)){
    die($mysqli->error);
}
$obj = $result ->fetch_object();
$iduser1 =  $obj->id;
$query1 =" delete from relations where (idUser1 ='$iduser1' && idUser2='$idUser2');";
if(!$ins = $mysqli-> query($query1)){
    die($mysqli->error);
}
$mysqli->close();
session_write_close();

header('Location: ../home.php?user='. $utente);

?>
