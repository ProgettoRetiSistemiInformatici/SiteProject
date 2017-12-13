<!DOCTYPE html>
<html>
<head>
	<?php include '../shared/header.php'; ?>
	<title>Registrazione</title>
</head>
<body>
	<form action="registration.php" method="post">
		<input type="text" name="username" placeholder="username" /><br>
		<input type="password" name="password" placeholder="password" /><br>
		<input type="text" name="email" placeholder="e-Mail" /><br>
		<input type="submit" value="Registrati" />
	</form>
</body>
</html>
