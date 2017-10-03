<?php 
//ottieni la password dal file
$arr = file(".htacred", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); 

$host = $arr[0];
$id = $arr[1];
$pass = $arr[2];
$db = $arr[3];

$mysqli = new mysqli($host, $id, $pass, $db);
if ($mysqli->connect_error) {
	die('Errore di connessione (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
?>
