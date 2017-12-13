<?php

require '../initialization/dbconnection.php';

session_start();

$username = $_POST['name'];
$password = $_POST['password'];

$_SESSION["utente"] = $username;

$username = filter_var($username, FILTER_SANITIZE_STRING);
$password = filter_var($password, FILTER_SANITIZE_STRING);

if(!$username || !$password){
	$error = 'Username e password sono obbligatori';
}

// Connessione al database
global $mysqli;
$password = hash('sha256', $password);
$query = $mysqli->query("SELECT * FROM login WHERE user = '$username' AND password = '$password'");
if($query->num_rows) {
	echo "Accesso consentito";
} else {
	$error = "Accesso rifiutato";
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
	<h1>Risultati accesso</h1>
	<?php if ($error): ?>
		<p style="color: red"><?php echo $error ?></p>
	<?php else: header('Location: /home.php?user='.$_SESSION["utente"]); ?>
	<?php endif ?>
</body>
</html>
