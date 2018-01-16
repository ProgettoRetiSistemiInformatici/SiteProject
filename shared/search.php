<?php

require '../initialization/dbconnection.php';

session_start();
global $mysqli;

$searchterm = $_POST['search'];

$query = "SELECT * FROM login WHERE email LIKE '%{$searchterm}%' OR firstname LIKE '%{$searchterm}%' OR lastname LIKE '%{$searchterm}%';";
$query.= "SELECT id, cover, title FROM albums WHERE title LIKE '%{$searchterm}%';";
$query.= "SELECT * FROM photo WHERE name LIKE '%{$searchterm}%' OR description LIKE '%{$searchterm}%';";
$query.= "SELECT id, photos_id FROM tags WHERE tag LIKE '%{$searchterm}%';";

if ($mysqli->multi_query($query)){
    $profiles = $mysqli->store_result();

    if($mysqli->next_result()){
        $albums = $mysqli->store_result();
    }
    if($mysqli-> next_result()){
        $photos = $mysqli->store_result();
    }
    if($mysqli->next_result()){
        $tagged_photos = $mysqli->store_result();
    }
}
else{
  die($mysqli->error);
}

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
          <div class="col-md-6">
            <?php while($profile = $profiles->fetch_object()){ ?>
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
                </div>
              </div>
            <?php  } ?>
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
                  <a href="../photo_page/comments.php?photo_id=<?php echo $photo->id?>">
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
            <?php while($tagged_photo = $tagged_photos->fetch_object()){
                $photos = explode(" ", $tagged_photo->photos_id);
                $photos = join("','", $photos);
                $query = "SELECT id, name, description FROM photo WHERE id IN ('$photos');";
                if(!$result = $mysqli->query($query)){
                  echo "Errore nella query dei tags" . $mysqli->error;
                }
                while($photo = $result->fetch_object()){
            ?>
              <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                  <a href="../photo_page/comments.php?photo=<?php echo $photo->id?>">
                    <img class="img-responsive img-rounded" src="<?php echo "/uploads/".$photo->name ?>" alt="Immagine">
                  </a>
                  <div class="caption text-center">
                    <p><b><?php echo $photo->description ?><b></p>
                  </div>
                </div>
              </div>
          <?php }
              } ?>
          </div>
        </div>
      </div>
    <?php $mysqli->close(); }
      if ($tagged_photos->num_rows == 0 && $photos->num_rows == 0
            && $profiles->num_rows == 0 && $albums->num_rows == 0){
    ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title text-center"><b>Search result</b></h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <h3 class="text-center"><b>Your search had no result</b></h3>
          </div>
        </div>
      </div>
    <?php  } ?>
    </div>
</body>
</html>
