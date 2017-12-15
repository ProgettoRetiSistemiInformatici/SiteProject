<?php
require '../initialization/dbconnection.php';

session_start();
global $photo;

error_reporting(E_ALL);
ini_set('display_errors', 1);

if($_GET['photo']!= null){
    $photo = $_GET['photo'];
    $photo = filter_var($photo, FILTER_SANITIZE_STRING);
    $_SESSION['photo'] = $photo;

    }

else {
    $photo = $_SESSION['photo'];
}

global $mysqli;
$query = "SELECT user, description, (rate/votes) AS finalrate FROM photo WHERE name ='$photo';";
$query .= "SELECT comment, user FROM comments WHERE photo ='$photo'";
if(!$mysqli->multi_query($query)){
    die($mysqli->error);
}
else{
    $result = $mysqli->store_result();
    $obj =$result->fetch_object();
    $fuser= $obj->user;
    $desc = $obj->description;
    $rate = $obj->finalrate;
    if($rate == NULL){
        $rate = 0;
    }
    if(!$mysqli->next_result()){
        die($mysqli->error);
    }
    $comments = $mysqli->store_result();
}
$_SESSION['fotouser'] = $fuser;
$mysqli -> close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include '../shared/meta.php' ?>
        <script src="https://apis.google.com/js/platform.js" async defer>
          {lang: 'en-GB'}
        </script>
    </head>
    <body>
      <div class="container">
        <?php include '../shared/header.php' ?>
      <!-- Photo Div -->
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <img class="img-responsive img-rounded" src="<?php echo "/uploads/" .$photo; ?>" alt="Immagine" class='img-responsive center-block'>
              </div>
              <div class="panel-body">
                <div class="col-md-12 text-center">
                  <p>Description: <?php echo $desc; ?> </p>
                  <div class="col-md-6 center-block text-center">
                     <p>Rating: <?php echo round($rate, 2); ?>/5</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3>Comments</h3>
              </div>
              <div class="panel-body">
                <div class="col-md-6 center-block">
                  <ul class="list-group">
                    <li class="list-group-item">
                      <?php
                        $result->data_seek(0);
                        if($comments->num_rows){
                          while($obj = $comments->fetch_object()){
                            echo "<p><b><a href='../profiles/profile.php?user=" . $obj->user. "'>" . $obj->user . "</a></b>: " . $obj->comment . "</p>";
                          }
                        }
                        else {
                          echo "<p>No comments yet <a class='btn btn-primary' href='../index.php'>Log in</a> to add a comment</p>";
                        }?>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </body>
</html>

<?php

session_write_close();
?>
