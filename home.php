<?php
//le foto andranno caricate da database tramite php
require 'initialization/dbconnection.php';

$user = $_SESSION['current_user'];

$query = "SELECT id, name, description FROM photo ORDER BY id DESC LIMIT 8;";
$query .= "SELECT * FROM login ORDER BY id DESC LIMIT 3;";

if ($mysqli->multi_query($query)){
    $photos = $mysqli->store_result();
    if($mysqli-> next_result()){
        $profiles = $mysqli->store_result();
    }
}
else{
  die($mysqli->error);
}

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
  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Lastest photos</h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <?php while($obj = $photos->fetch_object()): ?>
                <div class="col-md-6">
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
            <?php endwhile; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Newest Users</h3>
        </div>
        <div class="panel-body">
          <?php while($profile = $profiles->fetch_object()): ?>
              <div class="panel panel-default">
                <div class="panel-body">
                  <div class="col-md-4">
                    <img class="img-responsive img-rounded" src="<?php echo "../profiles/profile_images/". $profile->profile_image;?>"></h3>
                  </div>
                  <div class="col-md-8">
                    <ul class="list-group">
                      <?php
                            if (!empty($profile->firstname) || !empty($profile->lastname)){
                              echo "<li class='list-group-item'><b>Name:</b> " . $profile->firstname . " " . $profile->lastname . "</li>";
                            }
                            echo "<li class='list-group-item'><b>Email:</b> " . $profile->email . "</li>";
                            if(!empty($profile->birth)){
                              $date = date('d-m-Y',strtotime($profile->birth));
                              echo "<li class='list-group-item'><b>Birth Date:</b> " . $date ."</li>";
                            }
                            echo "<li class='list-group-item'><b>Level:</b> " . $profile->level . "</li>";

                            if (!empty($profile->descuser)){
                              echo "<li class='list-group-item'><b>About Me:</b> " . $profile->descuser . "</li>";
                            }
                      ?>
                    </ul>
                  </div>
                  <a href="../profiles/profile.php?user=<?php echo $profile->id ?>" class="btn btn-default pull-right">Show profile</a>
                </div>
              </div>
            <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
