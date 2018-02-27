<?php
require '../initialization/dbconnection.php';

$user = $_GET['user'];
$idgroup = $_SESSION['group_id'];
$query ="INSERT INTO membership (member_id,group_id) VALUES('$user','$idgroup');";
if(!$mysqli->query($query)){
    die($mysqli->error);
}
header('Location: group_page.php?group='.$idgroup);
?>