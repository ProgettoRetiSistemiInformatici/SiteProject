<?php

include ('dbconnection.php');

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

$username = filter_var($username, FILTER_SANITIZE_STRING);
$password = filter_var($password, FILTER_SANITIZE_STRING);
$email = filter_var($email, FILTER_SANITIZE_EMAIL);

if(!$username || !$password || !$email){
	$error = 'Username, password e email sono obbligatori';
}

// Connessione al database
global $mysqli;
$password = hash('sha256', $password); //Creazione dell'hash
$query = "INSERT INTO login (user, password, email) VALUES ('$username', '$password', '$email')";
// Esecuzione della query e controllo degli eventuali errori
if (!$mysqli->query($query)) {
	die($mysqli->error);
}
$mysqli->close();

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
	<?php else: header('Location: /home.php?user='.$username); ?>		
	<?php endif ?>
</body>
</html>
