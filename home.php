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
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
<title>Home</title>
<?php include 'shared/header.php'; ?>
<script src="https://apis.google.com/js/platform.js" async defer>
  {lang: 'en-GB'}
</script>
<style>
div.gallery {
    margin-top: 5px;
    border: 1px solid #ccc;
    width: 25%;
    float: left;
}

div.gallery:hover {
    border: 1px solid #777;
}

div.gallery img {
    width: 100%;
    height: auto;
}

div.desc {
    padding: 15px;
    text-align: center;
}
</style>
</head>
<body>

<header>
  <h1><b>PHOTOLIO</b></h1>
  <p><b>A site for photo sharing</b></p>
</header>

<!-- Menu -->
<?php include 'menu.php'; ?>
<!-- Photo Grid -->
<div class='container'>
  <?php $result->data_seek(0); /*Fetch object array */
    while($obj = $result->fetch_object()){ ?>
      <div class="gallery">
        <a href="photo_page/comments.php?photo=<?php echo $obj->name?>">
          <img src="<?php echo "/uploads/".$obj->name ?>" alt="Immagine" width="300" height="200">
        </a>
        <div class="desc"> <?php echo $obj->description ?> </br> <div class="g-plus" data-action="share" data-height="24"
                      data-href="<?php echo "http://photolio.com/photo_page/fotopage.php?photo=". $obj->name ?>"></div>
                      </div>
        	</div>
        </div>
      </div>
    <?php } ?>
</div>
</body>
</html>
