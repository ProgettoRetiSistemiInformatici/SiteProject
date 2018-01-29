<?php

require '../initialization/dbconnection.php';

session_start();

$user=$_SESSION['current_user'];

global $mysqli;
$querylevel ="select login.level as actual,lvl as next,exp from (login join levels on levels.lvl = (login.level+1)) where login.id ='$user';"
        . "select count(*) as numfoto from photo where user_id = '$user';"
        . "select count(*) as numfollow from relations where followed_id='$user';";
if(!$mysqli->multi_query($querylevel)){
    die($mysqli->error);
}
$result = $mysqli->store_result();
if($mysqli->next_result()){
  $resultp = $mysqli->store_result();
}
if($mysqli->next_result()){
    $resultf = $mysqli->store_result();
}
$obj = $result->fetch_object();
$actualLevel = $obj->actual;
$nextLevel = $obj->next;
$exp = $obj->exp;
$nfoto = $resultp->fetch_object();
$nfollow = $resultf->fetch_object();
$expFoto = ($nfoto->numfoto)*50;
$expFollow = ($nfollow->numfollow)*100;
$_SESSION['needed_exp'] = $exp;
$_SESSION['current_exp'] = $expFoto+$expFollow;
if($exp <= $_SESSION['current_exp']){
    $newlevel = $level +1;

    $querylvl = "update users set level = '$newlevel' where name ='$user';";
    if(!$mysqli->query($querylvl)){
        die($mysqli->error);
    }
}
session_write_close();
?>
