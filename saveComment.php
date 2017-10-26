<?php 
    include ('dbconnection.php');
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    session_start();
    
    $rate = filter_var($_POST['rate'], FILTER_SANITIZE_NUMBER_INT);
    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
    
    if(!$rate && !$comment){//Non ha né commentato né votato
        echo "Nor rate or comment are setted";
        header('Location: /home.php?user='.$_SESSION['utente']);
    }
    else if(!$rate){ //Ha solo commentato
        echo "Non ho votato ";
        addComment($comment);
    }
    else if(!$comment){ //Ha solo votato
        echo "Non ha commentato ";
        addRate($rate);
    }
    else{ //Ha commentato e votato
        echo "Ha votato e commentato ";
        addComment($comment);
        addRate($rate);
    }
    
    function addComment($comment){
        global $mysqli;
        $user = $_SESSION['utente'];
        $photo = $_SESSION['photo'];
        $comment = $mysqli -> real_escape_string($comment);
        $query = "INSERT INTO comments (user, photo, text) VALUES ('$user', '$photo', '$comment');";
        if(!$mysqli -> query($query)){
            die($mysqli->error);
            $error = "error in mysql!";
        }
    }
    function addRate($rate){
        global $mysqli;
        $photo = $_SESSION['photo'];
        $query = "SELECT rate FROM photo WHERE name = ('$photo');";
        
        if(!$result = $mysqli -> query($query)){
            die($mysqli->error);
            $error = "error in mysql!";
        }
        else{
            $obj = $result->fetch_object();
            if(($obj->rate) != 0){
                $rate = ($obj->rate + $rate) / 2;
            }
            $query = "UPDATE photo SET rate =  '$rate', votes= votes + 1 WHERE name = ('$photo');";
            if(!$mysqli -> query($query)){
                die($mysqli->error);
                $error = "error in mysql!";
            }
        }
    } 
    $mysqli -> close();
    unset($_SESSION['photo']);
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>Risultati caricamento commenti</h1>
	<?php if ($error): ?>
		<p style="color: red"><?php echo $error; ?></p>
	<?php else: header('Location: /home.php?user='.$_SESSION['utente']);?>	
	<?php endif ?>	
</body>
</html>