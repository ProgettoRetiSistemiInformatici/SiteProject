  <?php
//le foto andranno caricate da database tramite php
require 'initialization/dbconnection.php';
session_start();

//se non si e' loggati si viene reindirizzati nella pagina di registrazione/login
if(!isset($_SESSION["utente"])){
    header("Location: /index.php");
}

$user= $_SESSION['utente'];
global $mysqli;
$query = "SELECT photo.name, photo.description, users.profile_image FROM photo,users where users.name = '$user' ORDER BY photo.id DESC LIMIT 50;";
if (!$result = $mysqli->query($query)){
     echo $mysqli->error;
}
$result->data_seek(0);
$row = $result->fetch_row();
$mysqli->close();
$_SESSION['profminiature'] = $row[2];
$_SESSION['utente'] = $user;
session_write_close();
?>

<!DOCTYPE html>
<html lang='en'>
<head>
<?php include 'shared/meta.php'; ?>
<script src="https://apis.google.com/js/platform.js" async defer>
  {lang: 'en-GB'}
</script>
</head>
<body>
<div class="container">
<!-- Header -->
<?php include 'shared/header.php' ?>
<!-- Menu -->
<?php include 'shared/menuProfile.php'; ?>
<!-- Photo Grid -->
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="row">
        <?php $result->data_seek(0); /*Fetch object array */
          while($obj = $result->fetch_object()){ ?>
          <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
              <a href="photo_page/comments.php?photo=<?php echo $obj->name?>">
                <img class="img-responsive img-rounded" src="<?php echo "/uploads/".$obj->name ?>" alt="Immagine">
              </a>
              <div class="caption text-center">
                <p><b><?php echo $obj->description ?></b></p>
                <div class="g-plus" data-action="share" data-height="24" data-href="<?php echo "http://photolio.com/photo_page/fotopage.php?photo=". $obj->name ?>">
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
</body>
</html>
