<?php
    require '../initialization/dbconnection.php';

    $rate = filter_var($_POST['rate'], FILTER_SANITIZE_NUMBER_INT);
    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
    $user_id = $_SESSION['current_user'];

    if(empty($_GET['photo_id']) && !empty($_GET['album_id'])){
      $album_id = $_GET['album_id'];
      $photo_id = NULL;
    }
    else if(!empty($_GET['photo_id']) && empty($_GET['album_id'])){
      $photo_id = $_GET['photo_id'];
      $album_id = NULL;
    }
    else{
      die("ERROR: I don't have a photo or album ID");
    }

    if(!$rate && !$comment){//Non ha né commentato né votato
        echo "Nor rate or comment are setted";
        header('Location: ../home.php?user='.$_SESSION['current_user']);
    }
    else if(!$rate){ //Ha solo commentato
        echo "Non ha votato ";
        $comment = $mysqli->real_escape_string($comment);
        addComment($comment, $photo_id, $album_id, $user_id, $mysqli);
    }
    else if(!$comment){ //Ha solo votato
        echo "Non ha commentato ";
        addRate($rate, $photo_id, $album_id, $mysqli);
    }
    else{ //Ha commentato e votato
        echo "Ha votato e commentato ";
        addComment($comment, $photo_id, $album_id, $user_id, $mysqli);
        addRate($rate, $photo_id, $album_id, $mysqli);
    }

    function addComment($comment, $photo_id, $album_id, $user_id, $mysqli){
        if(!isset($photo_id) && isset($album_id)){
          if(!$result = $mysqli->query("INSERT INTO comments(user_id, album_id, comment) VALUES ('$user_id', '$album_id', '$comment');")){
            $error = "error in mysql!";
            die($mysqli->error);
          }
        }
        else if(!isset($album_id) && isset($photo_id)){
          if(!$result = $mysqli->query("INSERT INTO comments(user_id, photo_id, comment) VALUES ('$user_id', '$photo_id', '$comment');")){
            $error = "error in mysql!";
            die($mysqli->error);
          }
        }
        else{
          die("ERROR: Both are null;");
        }
    }
    function addRate($rate, $photo_id, $album_id, $mysqli){

      if(!isset($photo_id) && isset($album_id)){
        if(!$result = $mysqli->query("SELECT rate FROM albums WHERE id = '$album_id';")){
          $error = "error in mysql!";
          die($mysqli->error);
        }
        else{
            $obj = $result->fetch_object();
            if(($obj->rate) != 0){
                $rate = ($obj->rate + $rate);
            }
            $query = "UPDATE albums SET rate = '$rate', votes = votes + 1 WHERE id = ('$album_id');";
            if(!$mysqli -> query($query)){
                die($mysqli->error);
                $error = "error in mysql!";
            }
        }
      }
      else if(!isset($album_id) && isset($photo_id)){
        if(!$result = $mysqli->query("SELECT rate FROM photo WHERE id = '$photo_id';")){
          $error = "error in mysql!";
          die($mysqli->error);
        }
        else{
            $obj = $result->fetch_object();
            if(($obj->rate) != 0){
                $rate = ($obj->rate + $rate);
            }
            $query = "UPDATE photo SET rate = '$rate', votes = votes + 1 WHERE id = ('$photo_id');";
            if(!$mysqli -> query($query)){
                die($mysqli->error);
                $error = "error in mysql!";
            }
        }
      }
      else{
        die("ERROR: Both are null;");
      }
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
		<p style="color: red"><?php echo $error; ?></p>
	<?php elseif(isset($_GET['photo_id'])): header('Location: ../gallery/photo_page.php?photo_id=' . $photo_id);?>
  <?php elseif(isset($_GET['album_id'])): header('Location: ../gallery/album_page.php?album=' . $album_id);?>
  <?php endif ?>
</body>
</html>
