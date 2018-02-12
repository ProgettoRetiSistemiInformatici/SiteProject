<?php

require '../initialization/dbconnection.php';

$password = $_POST['password'];
$email = $_POST['email'];

$password = filter_var($password, FILTER_SANITIZE_STRING);
$email = filter_var($email, FILTER_SANITIZE_EMAIL);

if(!$password || !$email){
	$error = 'Email e password sono obbligatori';
}

$password = hash('sha256', $password);//Creazione dell'hash
$mysqli-> real_escape_string($email);
$mysqli-> real_escape_string($password);
$nick = explode('@', $email);
$query = "INSERT INTO login (password, email, firstname) VALUES ('$password', '$email', '$nick[0]');";
// Esecuzione della query e controllo degli eventuali errori
if (!$mysqli->query($query)) {
	die($mysqli->error);
}

$query = "SELECT id FROM login WHERE email = '$email';";
if($result = $mysqli->query($query)){
	$_SESSION['current_user'] = $result->fetch_object()->id;
}

$mysqli->close();
session_write_close();

header('Location: ../home.php');

?>
