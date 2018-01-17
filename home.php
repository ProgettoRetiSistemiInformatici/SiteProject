<?php
//le foto andranno caricate da database tramite php
require 'initialization/dbconnection.php';
session_start();

//se non si e' loggati si viene reindirizzati nella pagina di registrazione/login
if(!isset($_SESSION["current_user"])){
    header("Location: /index.php");
}

$user= $_SESSION['current_user'];
global $mysqli;
$query = "SELECT id, name, description FROM photo ORDER BY id DESC LIMIT 50;";
if (!$result = $mysqli->query($query)){
     echo $mysqli->error;
}

$result->data_seek(0);
$row = $result->fetch_row();
$mysqli->close();

session_write_close();

?>

<!DOCTYPE html>
<html lang='en'>
<head>
<?php include 'shared/meta.php'; ?>
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
            <div class="col-sm-4">
              <div class="panel panel-default">
                <div class="panel-body">
                  <a href="photo_page/comments.php?photo_id=<?php echo $obj->id?>">
                    <img style="height:200px" class="center-block img-responsive img-rounded" src="<?php echo "/uploads/".$obj->name ?>" alt="Immagine">
                  </a>
                </div>
                <table class="table">
                  <ul class="list-group">
                    <li class="list-group-item text-center"><p><b><?php echo $obj->description ?></b></p></li>
                    <li class="list-group-item"><div class="g-plus" data-action="share" data-height="24" data-href="<?php echo "http://photolio.com/photo_page/fotopage.php?photo=". $obj->id ?>"></div>
                      <div class="fb-share-button pull-right" data-href="http://localhost:8000/photo_page/comments.php?photo_id=<?php echo $obj->id; ?>" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Flocalhost%3A8000%2Fphoto_page%2Fcomments.php%3Fphoto_id%3D<?php echo $obj->id; ?>&amp;src=sdkpreparse">Condividi</a></div></li>
                  </li>
                  </ul>
                </table>
              </div>
            </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php include 'test.php' ?>
</div>
<script src="https://apis.google.com/js/platform.js" async defer>
  {lang: 'en-GB'}
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.async=true;
      js.src = 'https://connect.facebook.net/it_IT/sdk.js#xfbml=1&version=v2.11';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
</body>
</html>
