<?php 
    include('dbconnection.php');
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    session_start();
    
    $text = $_POST['comment'];
    $text = $mysqli -> real_escape_string($text);
    
    $user = $_SESSION['utente'];
    $photo = $_SESSION['photo'];
    
    $query = "INSERT INTO comments (user, photo, text) VALUES ('$user', '$photo', '$text');";
    if(!$mysqli -> query($query)){
        die($mysqli->error);
        $error = "error in mysql!";
    }
    
    $mysqli -> close();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>Risultati caricamento commenti</h1>
	<?php if ($error): ?>
		<p style="color: red"><?php echo $error; print_r($_FILES); ?></p>
	<?php else: header('Location: /home.php?user='.$_SESSION['utente']);?>	
	<?php endif ?>
        <?php exit();?>	
</body>
</html>