<?php

require '../initialization/dbconnection.php';

session_start();
global $mysqli;

$searchterm = $_POST['search'];

$query = "SELECT * FROM users WHERE name LIKE '%{$searchterm}%' OR firstname LIKE '%{$searchterm}%' OR lastname LIKE '%{$searchterm}%';";
$query.= "SELECT id, cover, title FROM albums WHERE title LIKE '%{$searchterm}%';";
$query.= "SELECT * FROM photo WHERE name LIKE '%{$searchterm}%' OR description LIKE '%{$searchterm}%';";
$query.= "SELECT id, photo FROM tags WHERE tag LIKE '%{$searchterm}%';";

if (!$mysqli->multi_query($query)){
   die($mysqli->error);
}

if($result = $mysqli->store_result()){
    //Store first query result(profile info)
    $profiles = $mysqli->store_result();

}
if($mysqli->next_result()){
    //Store second query result
    $albums= $mysqli->store_result();
}
if($mysqli-> next_result()){
    //Store third query result
    $photos =$mysqli->store_result();
}
if($mysqli->next_result()){
  //Store fourth query result
  $tagged_photos = $mysqli->store_result();
}
$mysqli->close();
session_write_close();
?>

<!DOCTYPE html>
<html>
<head>
  <?php include '../shared/meta.php'; ?>
</head>
<body>
  <div class="container">
    <?php include '../shared/header.php'; ?>
    <?php include '../shared/menuProfile.php'; ?>
    <?php if($albums->num_rows != 0){ ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title text-center"><b>Related Albums</b></h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <?php while($album = $albums->fetch_object()){ ?>
            <div class="col-sm-6 col-md-4">
              <div class="thumbnail">
                <a href='#COLLEGARE A SHOW ALBUM'>
                  <img class="img-responsive img-rounded" src='<?php
                              if($album->cover==null){
                                echo "../google-login/images/album.png";}
                              else {
                                echo "../uploads/".$album->cover;
                              }?>'></a>
                <div class="caption">
                  <h3><?php echo $album->title; ?></h3>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php  } ?>
    <?php if($profiles->num_rows != 0){ ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title text-center"><b>Related Profiles</b></h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <?php while($profile = $result->fetch_object()){ ?>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">
                    <p><b>Profile info</b></p>
                    <img class="img-responsive img-rounded" src="<?php echo "profile_images/". $profile->profile_image;?>"></h3>
                </div>
                <div class="panel-body">
                  <ul class="list-group">
                    <?php
                          if (!empty($profile->fistname) || !empty($profile->lastname)){
                            echo "<li class='list-group-item'><b>Name:</b> " . $profile->firstname . " " . $profile->lastname . "</li>";
                          }
                          echo "<li class='list-group-item'><b>Email:</b> " . $profile->email . "</li>";
                          echo "<li class='list-group-item'><b>Birth Date:</b> " . $profile->birth ."</li>";
                          echo "<li class='list-group-item'><b>Level:</b> " . $profile->level . "</li>";

                          if (!empty($profile->descuser)){
                            echo "<li class='list-group-item'><b>About Me:</b> " . $profile->descuser . "</li>";
                          }
                      ?>
                  </ul>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php  } ?>
    <?php if($photos->num_rows != 0){ ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title text-center"><b>Related Photos</b></h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <?php while($photo = $photos->fetch_object()){ ?>
              <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                  <a href="../photo_page/comments.php?photo=<?php echo $photo->name?>">
                    <img class="img-responsive img-rounded" src="<?php echo "/uploads/".$photo->name ?>" alt="Immagine">
                  </a>
                  <div class="caption text-center">
                    <p><b><?php echo $photo->description ?><b></p>
                  </div>
                </div>
              </div>
          <?php } ?>
          </div>
        </div>
      </div>
    <?php  } ?>
    <?php if($tagged_photos->num_rows != 0){ ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title text-center"><b>Related Tags</b></h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <?php while($tagged_photo = $tagged_photos->fetch_object()){ ?>
              <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                  <a href="../photo_page/comments.php?photo=<?php echo $tagged_photo->name?>">
                    <img class="img-responsive img-rounded" src="<?php echo "/uploads/".$tagged_photo->name ?>" alt="Immagine">
                  </a>
                  <div class="caption text-center">
                    <p><b><?php echo $tagged_photo->description ?><b></p>
                  </div>
                </div>
              </div>
          <?php } ?>
          </div>
        </div>
      </div>
    <?php  } ?>
    </div>
</body>
</html>
