<?php
session_start();

require '../initialization/dbconnection.php';
$user = $_SESSION['current_user'];
$gid = $_GET['group'];
$query = "DELETE from groups where id='$gid';";
$query.= "DELETE from membership where group_id ='$gid';";
$query.= "DELETE from chat where group_id ='$gid';";
if(!$mysqli->multi_query($query)){
    die($mysqli->error);
}
else {
    while($mysqli->more_results()){
        $mysqli->next_result();
    }
}
header('Location: ../profiles/profile.php?user='.$user);
?>