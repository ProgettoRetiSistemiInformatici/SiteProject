<?php
    require '../initialization/dbconnection.php';

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();

    $rate = filter_var($_POST['rate'], FILTER_SANITIZE_NUMBER_INT);
    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
    $photo_id = $_SESSION['photo_id'];

    if(!$rate && !$comment){//Non ha né commentato né votato
        echo "Nor rate or comment are setted";
        header('Location: ../home.php?user='.$_SESSION['current_user']);
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
        $user_id = $_SESSION['current_user'];
        $photo_id = $_SESSION['photo_id'];
        $comment = $mysqli -> real_escape_string($comment);
        $query = "INSERT INTO comments (user_id, photo_id, comment) VALUES ('$user_id', '$photo_id', '$comment');";
        if(!$mysqli -> query($query)){
            die($mysqli->error);
            $error = "error in mysql!";
        }
    }
    function addRate($rate){
        global $mysqli;
      
        $photo_id = $_SESSION['photo_id'];
        $query = "SELECT rate FROM photo WHERE id = '$photo_id';";

        if(!$result = $mysqli -> query($query)){
            die($mysqli->error);
            $error = "error in mysql!";
        }
        else{
            $obj = $result->fetch_object();
            if(($obj->rate) != 0){
                $rate = ($obj->rate + $rate);
            }
            $query = "UPDATE photo SET rate =  '$rate', votes= votes + 1 WHERE id = ('$photo_id');";
            if(!$mysqli -> query($query)){
                die($mysqli->error);
                $error = "error in mysql!";
            }
        }
    }
    $mysqli -> close();
    unset($_SESSION['photo_id']);
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
	<?php else: header('Location: ../photo_page/comments.php?photo_id=' . $photo_id);?>
	<?php endif ?>
</body>
</html>
