<?php
session_start();

$arr = file($_SERVER['DOCUMENT_ROOT'] . "/.htacred", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$host = $arr[0];
$id = $arr[1];
$pass = $arr[2];

$mysqli = new mysqli($host, $id, $pass, 'photolio');
if ($mysqli->connect_error) {
	$_SESSION['db_connection'] = false;
}
else{
	$_SESSION['db_connection'] = true;
}
?>
