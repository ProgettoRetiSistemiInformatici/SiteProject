<?php

require '../initialization/dbconnection.php';

$query = "SELECT login.level AS userLevel, login.exp AS userExp, levels.exp AS neededExp FROM login INNER JOIN levels ON levels.level = login.level AND login.id = $current_user;";

if(!$result = $mysqli->query($query)){
    echo ($mysqli->error);
}

$obj = $result->fetch_object();
$userLevel = $obj->userLevel;
$userExp = $obj->userExp;
$neededExp = $obj->neededExp;
if($userExp > $neededExp){
  $mysql->query("UPDATE login SET level = $userLevel + 1 WHERE id = '$current_user';");
}

session_write_close();
?>
