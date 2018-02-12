<?php

require '../initialization/dbconnection.php';

$email = $_POST['email'];
$password = $_POST['password'];

$email = filter_var($email, FILTER_SANITIZE_STRING);
$password = filter_var($password, FILTER_SANITIZE_STRING);

if(!$email || !$password){
	$error = 'Email e password sono obbligatori';
}

$password = hash('sha256', $password);

$query = "SELECT * FROM login WHERE email = '$email' AND password = '$password';";
$result = $mysqli->query($query);
if($result->num_rows){
	echo "Accesso consentito";
	$_SESSION['current_user'] = $result->fetch_object()->id;
   	header('Location: /home.php');  
} else {
	$error = "Accesso rifiutato, password o id errati oppure account inesistente.";
    echo $error;  
}

$mysqli->close();

session_write_close();
?>
