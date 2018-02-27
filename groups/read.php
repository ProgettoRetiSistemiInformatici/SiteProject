<?php
require '../initialization/dbconnection.php';
$idgroup = $_GET['group_id'];
$query="SELECT * FROM chat where group_id = '$idgroup' ORDER BY id ASC;";
//execute query
$story;
if (!$result = $mysqli->query($query)) {
    //If the query was NOT successful
    echo "An error occured";
    echo $mysqli->error;
}else{
     //If the query was successful
    while ($row = $result->fetch_object()) {
        $username=$row->username;
        $text=$row->text;
        $time=date('G:i', strtotime($row->time)); //outputs date as # #Hour#:#Minute#
        echo "<p style='color: blue'>$time | $username: $text</p>\n";
    }
}
$mysqli->close();
?>