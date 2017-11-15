<?php

session_start();

$host = $_SERVER['SERVER_NAME'];

$_SESSION['host'] = $host;
$username = $_POST['username'];
$password = $_POST['password'];
$_SESSION["utente"] = $username;
$username = filter_var($username, FILTER_SANITIZE_STRING);
$password = filter_var($password, FILTER_SANITIZE_STRING);

if(!$username || !$password){
	$error = 'Username e password sono obbligatori';
}

$mysqli = new mysqli($host, $username, $password);
if ($mysqli->connect_error){
	die ('Errore di connessione(' . $mysqli->connect_errno . ')' . $mysqli->connect_error);
}

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
	<?php else: header('Location: /home.php?user='.$username); ?>
	<?php endif ?>
</body>
</html>

