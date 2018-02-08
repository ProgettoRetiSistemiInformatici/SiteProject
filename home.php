<?php
//le foto andranno caricate da database tramite php
require 'initialization/dbconnection.php';

$user = $_SESSION['current_user'];

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
                  <a href="../gallery/photo_page.php?photo_id=<?php echo $obj->id?>">
                    <img style="height:200px" class="center-block img-responsive img-rounded" src="<?php echo "/uploads/".$obj->name ?>" alt="Immagine">
                  </a>
                </div>
                <table class="table">
                  <ul class="list-group">
                    <li class="list-group-item text-center"><h4><?php echo $obj->description ?></h4></li>
                    <li class="list-group-item text-center">
                      <a href="https://plus.google.com/share?url=http%3A%2F%2Flocalhost%3A8000%2Fphoto_page%2Fcomments.php%3Fphoto_id%3D<?php echo $obj->id; ?>&amp"
                        class="btn btn-danger" aria-hidden="true"
                        target="_blank">Share on G+</a>
                      <a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Flocalhost%3A8000%2Fphoto_page%2Fcomments.php%3Fphoto_id%3D<?php echo $obj->id; ?>&amp"
                        class="btn btn-primary" aria-hidden="true"
                        target="_blank">Share on Facebook</a>
                  </li>
                  </ul>
                </table>
              </div>
            </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
</body>
</html>
