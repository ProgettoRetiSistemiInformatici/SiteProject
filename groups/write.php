<?php
require '../initialization/dbconnection.php';

//get user-input from url
$username=substr($_GET["username"], 0, 32);
$text=substr($_GET["text"], 0, 128);
$idgroup = $_GET['group_id'];
//escaping is extremely important to avoid injections!
$nameEscaped = htmlentities($mysqli->real_escape_string($username));
$textEscaped = htmlentities($mysqli->real_escape_string($text));
$query="INSERT INTO chat (username, text,group_id) VALUES ('$nameEscaped', '$textEscaped','$idgroup')";
//execute query
if (!$mysqli->query($query)){    
    //If the query was NOT successful
    echo "An error occurred";
    echo $mysqli->error;
}

$mysqli->close();
?>