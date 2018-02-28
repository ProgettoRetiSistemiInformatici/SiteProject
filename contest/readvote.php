<?php
require '../initialization/dbconnection.php';

$id = $_GET['photo'];
$query = "SELECT votes from photo where id ='$id';";
if($result = $mysqli->query($query)){
    $res = $result->fetch_row();
    $votes = $res[0];
    echo "<p>".$votes."</p>"; 
}
else {
    echo "N.A.";
}
$mysqli->close();
?>