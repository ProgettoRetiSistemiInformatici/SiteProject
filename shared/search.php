<?php

require '../initialization/dbconnection.php';

$searchterm = $_POST['search'];

$query = "SELECT id, firstname, lastname, birth, level, descuser FROM login WHERE firstname LIKE '%{$searchterm}%' OR lastname LIKE '%{$searchterm}%';";
$query.= "SELECT id, cover, title FROM albums WHERE title LIKE '%{$searchterm}%';";
$query.= "SELECT id, name, title FROM photo WHERE name LIKE '%{$searchterm}.jpg%' OR name LIKE '%{$searchterm}.jpeg%' OR name LIKE '%{$searchterm}.png%' OR title LIKE '%{$searchterm}%';";
$query.= "SELECT tags.id AS tag_id, photo.id AS photo_id, photo.name AS photo_name, photo.title AS photo_title FROM tags INNER JOIN tag_reference ON tags.tag LIKE '%{$searchterm}%' AND tags.id = tag_reference.tag_id INNER JOIN photo ON photo.id = tag_reference.photo_id;";

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
                    <a href="../gallery/photo_page.php?photo_id=<?php echo $photo->id?>">
                      <img style="height:200px" class="center-block img-responsive img-rounded" src="<?php echo "/uploads/".$photo->name ?>" alt="Immagine">
                    </a>
                  </div>
                  <table class="table">
                    <ul class="list-group">
                      <li class="list-group-item text-center"><h4><?php echo $photo->title ?></h4></li>
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
            <?php while($tag = $tags->fetch_object()): ?>
            <div class="col-sm-4">
              <div class="panel panel-default">
                <div class="panel-body">
                  <a href="../gallery/photo_page.php?photo_id=<?php echo $tag->photo_id?>">
                    <img style="height:200px" class="center-block img-responsive img-rounded" src="<?php echo "/uploads/".$tag->photo_name ?>" alt="Immagine">
                  </a>
                </div>
                <table class="table">
                  <ul class="list-group">
                    <li class="list-group-item text-center"><h4><?php echo $tag->photo_title ?></h4></li>
                  </ul>
                </table>
              </div>
            </div>
          <?php endwhile; ?>
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
