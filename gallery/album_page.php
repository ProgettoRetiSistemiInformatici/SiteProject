<?php
require '../initialization/dbconnection.php';
require  '../profiles/tokenize.php';

session_start();
$album = $_SESSION['album'];

if($album == NULL){
    echo "error, album not selected";
}
$idS = $album->photos_id;
$queryfinal = "SELECT name,description FROM photo ";
$queryfinal .= tokenize($idS,"|");;

global $mysqli;
if(!$result = $mysqli->query($queryfinal)){
    echo $mysqli->error;
}
$result->data_seek(0);

$mysqli->close();
session_write_close();

?>
<html>
    <head>
        <?php include '../shared/meta.php'; ?>
        <script src="https://apis.google.com/js/platform.js" async defer>
          {lang: 'en-GB'}
        </script>
    </head>
    <body>
        <div class="container">
            <!-- Header -->
            <?php include '../shared/header.php' ?>
            <!-- Menu -->
            <?php include '../shared/menuProfile.php'; ?>
            <!-- Album's Photo Grid -->
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="row">
                  <?php  while($obj = $result->fetch_object()){ ?>
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
