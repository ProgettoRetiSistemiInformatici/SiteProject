<?php
$arr = file($_SERVER['DOCUMENT_ROOT'] . "/.htacred", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$host = $arr[0];
$id = $arr[1];
$pass = $arr[2];

// Create connection
$conn = new mysqli($host, $id, $pass);
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE photolio";
if ($conn->query($sql) === TRUE) {
} else {
   echo "Error creating database: " . $conn->error;
}

$conn->close();
?>
