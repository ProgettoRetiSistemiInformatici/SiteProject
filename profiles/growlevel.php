<?php

require '../initialization/dbconnection.php';

session_start();

$user=$_SESSION['utente'];

global $mysqli;
$query ="select level from users where name ='$user';"
        . "select count(*) as numfoto from photo where user = '$user';"
        . "select count(*) as numfollow from (relations join users on relations.idUser2 = users.id) where users.name='$user';";
if(!$mysqli->multi_query($query)){
    die($mysqli->error);
}
$result1 = $mysqli->store_result();
if($mysqli->next_result()){
  $resultp = $mysqli->store_result();
}
if($mysqli->next_result()){
    $resultf = $mysqli->store_result();
}
$obj = $result->fetch_object();
$level = $obj->level;
$nfoto = $resultp->fetch_row();
$nfollow = $resultf->fetch_row();
$expcap = $level*1000;
$expfoto = ($nfoto[0])*50;
$expfollow = ($nfollow[0])*100;

if($expcap <= $expfoto + $expfollow){
    $newlevel = $level +1;
}
$querylvl = "update users set level = '$newlevel' where name ='$user';";
if(!$mysqli->query($querylvl)){
    die($mysqli->error);
}

header('Location: profile.php?user='.$user);
session_write_close();
?>
