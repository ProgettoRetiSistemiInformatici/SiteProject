<?php

require '../initialization/dbconnection.php';

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$email = filter_var($email, FILTER_SANITIZE_STRING);
$password = filter_var($password, FILTER_SANITIZE_STRING);

if(!$email || !$password){
	$error = 'Email e password sono obbligatori';
}

// Connessione al database
global $mysqli;
$password = hash('sha256', $password);

$query = "SELECT id FROM login WHERE email = '$email' AND password = '$password';";
if($result = $mysqli->query($query)){
	echo "Accesso consentito";
} else {
	$error = "Accesso rifiutato";
}

$_SESSION['current_user'] = $result->fetch_object()->id;

$mysqli->close();

session_write_close();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>Risultati accesso</h1>
	<?php if ($error): ?>
		<p style="color: red"><?php echo $error ?></p>
	<?php else: header('Location: /home.php'); ?>
	<?php endif ?>
</body>
</html>
