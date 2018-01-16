<?php
//include('MySession.php');
require '../initialization/dbconnection.php';
session_start();


$password = $_POST['password'];
$email = $_POST['email'];

$password = filter_var($password, FILTER_SANITIZE_STRING);
$email = filter_var($email, FILTER_SANITIZE_EMAIL);

if(!$password || !$email){
	$error = 'Email e password sono obbligatori';
}

// Connessione al database
global $mysqli;

$password = hash('sha256', $password);//Creazione dell'hash
$mysqli-> real_escape_string($email);
$mysqli-> real_escape_string($password);
$query = "INSERT INTO login (password, email) VALUES ('$password', '$email');";
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

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>Risultati registrazione</h1>
	<?php if ($error): ?>
		<p style="color: red"><?php echo $error ?></p>
	<?php else: header('Location: ../home.php'); ?>
	<?php endif ?>
</body>
</html>
