<?php

require '../initialization/dbconnection.php';

$searchterm = $_POST['search'];

$query = "SELECT * FROM login WHERE email LIKE '%{$searchterm}%' OR firstname LIKE '%{$searchterm}%' OR lastname LIKE '%{$searchterm}%';";
$query.= "SELECT id, cover, title FROM albums WHERE title LIKE '%{$searchterm}%';";
$query.= "SELECT * FROM photo WHERE name LIKE '%{$searchterm}.jpg%' OR name LIKE '%{$searchterm}.jpeg%' OR name LIKE '%{$searchterm}.png%' OR description LIKE '%{$searchterm}%';";
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
        $tags = $mysqli->store_result();
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
    <?php if($albums->num_rows != 0): ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title text-center"><b>Related Albums</b></h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <?php while($album = $albums->fetch_object()): ?>
              <div class="col-sm-4">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <a href='../gallery/album_page.php?album=<?php echo $album->id; ?>'>
                      <img class="img-responsive img-rounded" src='<?php
                                  if($album->cover==null){
                                    echo "../google-login/images/album.png";}
                                  else {
                                    echo "../uploads/".$album->cover;
                                  }?>'>
                    </a>
                  </div>
                  <table class="table">
                    <ul class="list-group">
                      <li class="list-group-item text-center"><h4><?php echo $album->title; ?></h4></li>
                    </ul>
                  </table>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?php if($profiles->num_rows != 0): ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title text-center"><b>Related Profiles</b></h3>
        </div>
        <div class="panel-body">
          <div class="col-md-6">
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
    <?php endif; ?>
    <?php if($photos->num_rows != 0): ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title text-center"><b>Related Photos</b></h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <?php while($photo = $photos->fetch_object()): ?>
              <div class="col-sm-4">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <a href="../photo_page/comments.php?photo_id=<?php echo $photo->id?>">
                      <img style="height:200px" class="center-block img-responsive img-rounded" src="<?php echo "/uploads/".$photo->name ?>" alt="Immagine">
                    </a>
                  </div>
                  <table class="table">
                    <ul class="list-group">
                      <li class="list-group-item text-center"><h4><?php echo $photo->description ?></h4></li>
                    </ul>
                  </table>
                </div>
              </div>
          <?php endwhile; ?>
          </div>
        </div>
      </div>
    <?php  endif; ?>
    <?php if($tags->num_rows != 0): ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title text-center"><b>Related Tags</b></h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <?php while($tag = $tags->fetch_object()):
                $photos = explode(" ", $tag->photos_id);
                $photos = join("','", $photos);
                $query = "SELECT id, name, description FROM photo WHERE id IN ('$photos');";
                if(!$result = $mysqli->query($query)){
                  echo "Errore nella query dei tags" . $mysqli->error;
                }
                if($result->num_rows):
                  while($photo = $result->fetch_object()):
            ?>
            <div class="col-sm-4">
              <div class="panel panel-default">
                <div class="panel-body">
                  <a href="../photo_page/comments.php?photo_id=<?php echo $photo->id?>">
                    <img style="height:200px" class="center-block img-responsive img-rounded" src="<?php echo "/uploads/".$photo->name ?>" alt="Immagine">
                  </a>
                </div>
                <table class="table">
                  <ul class="list-group">
                    <li class="list-group-item text-center"><h4><?php echo $photo->description ?></h4></li>
                  </ul>
                </table>
              </div>
            </div>
          <?php endwhile;
          else: ?>
            <div class="col-sm-4">
              <div class="panel panel-default">
                <div class="panel-body">
                  <img style="height:200px" class="center-block img-responsive img-rounded" src="<?php echo "/uploads/broken.png" ?>" alt="Immagine">
                </div>
                <table class="table">
                  <ul class="list-group">
                    <li class="list-group-item text-center"><h4>This photo doesn't exist anymore :(</h4></li>
                  </ul>
                </table>
              </div>
            </div>
        <?php endif;
        endwhile; ?>
      </div>
    </div>
  </div>
<?php $mysqli->close();
endif;
if ($tags->num_rows == 0 && $photos->num_rows == 0 && $profiles->num_rows == 0 && $albums->num_rows == 0): ?>
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
<?php endif ?>
</div>
</body>
</html>
