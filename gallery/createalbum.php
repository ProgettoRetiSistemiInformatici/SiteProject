<?php

include("../dbconnection.php");

session_start();

global $mysqli;
$ids = $_SESSION['ids'];
$user= $_SESSION['utente'];
$titolo = $_SESSION['titlealbum'];
$query="INSERT into album (titolo,user,idFoto) values('$titolo','$user','$ids')";
if(!$mysqli->query($query)){
    die($mysqli->error);
}
header("Location: /profiles/profile.php?user=". $user);
exit();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>