<?php

require '../initialization/dbconnection.php';

session_start();

$user = $_GET['user'];
$current_user = $_SESSION['current_user'];

if($user === $current_user){
  $equals = true;
}
else{
  $equals = false;
}

$date_right;

$query = "SELECT * FROM login WHERE id = '$user';";
$query .= "SELECT id, name, description FROM photo WHERE user_id = '$user' ORDER BY 'id' DESC LIMIT 15;";
$query .= "SELECT * FROM albums WHERE user_id='$user' ORDER BY 'id' DESC LIMIT 3;";
$query .= "SELECT * FROM relations WHERE follower_id = '$current_user' AND followed_id = '$user';";
$query .= "SELECT id FROM relations WHERE follower_id = '$user';";
$query .= "SELECT id FROM relations WHERE followed_id = '$user';";
if ($mysqli->multi_query($query)){
    if($result = $mysqli->store_result()){
        //Store first query result(profile info)
        $profile = $result->fetch_object();
    }
    if($mysqli->next_result()){
        $photos = $mysqli->store_result();
    }
    if($mysqli-> next_result()){
        $albums = $mysqli->store_result();
    }
    if($mysqli->next_result()){
        $follows = $mysqli->store_result();
    }
    if($mysqli->next_result()){
      $num_following = $mysqli->store_result()->num_rows;
    }
    if($mysqli->next_result()){
      $num_follower = $mysqli->store_result()->num_rows;
    }
    else {
        die($mysqli->error);
    }
}

$neededExp = $mysqli->query("SELECT exp FROM levels WHERE level = '$profile->level';");
$exp = round(($profile->exp/$neededExp->fetch_object()->exp) * 100, 2);

if(!empty($profile->birth)){
  $date_from_sql = $profile->birth;
 $date_right = date('d-m-Y',strtotime($date_from_sql));
}

session_write_close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include '../shared/meta.php' ?>
</head>
<body>
<div class="container">

<?php include '../shared/header.php' ?>
<!-- Menu -->
<?php include '../shared/menuProfile.php' ?>

<!-- Profile Info -->
<div class="row">
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">
          <p><b>Profile info</b></p>
          <?php
            if(!empty($profile->profile_image)){
              echo '<img class="img-responsive img-rounded" src="profile_images/' . $profile->profile_image . '"></h3>';
            }
            else{
              echo '<img class="img-responsive img-rounded" src="profile_images/Default.png"></h3>';
            }
          ?>
      </div>
      <div class="panel-body">
        <ul class="list-group">
          <?php
                if (!empty($profile->firstname) || !empty($profile->lastname)){
                  echo "<li class='list-group-item'><b>Name:</b> " . $profile->firstname . " " . $profile->lastname . "</li>";
                }
                echo "<li class='list-group-item'><b>Email:</b> " . $profile->email . "</li>";
                if(!empty($date_right)){
                  echo "<li class='list-group-item'><b>Birth Date:</b> " . $date_right ."</li>";
                }
                echo "<li class='list-group-item'><b>Level:</b> " . $profile->level . "</li>";
                echo "<li class='list-group-item'>
                        <div class='progress' style='margin-top:7px; margin-bottom:7px'>
                          <div class='progress-bar' role='progressbar' aria-valuenow=". $exp . " aria-valuemin='0' aria-valuemax='100' style='width: " . $exp . "%;'>
                            Exp " . $exp . "%
                          </div>
                        </div>
                      </li>";
                if (!empty($profile->descuser)){
                  echo "<li class='list-group-item'><b>About Me:</b> " . $profile->descuser . "</li>";
                }
                echo "<li class='list-group-item'><a href='following.php?user=" . $user . "'><b>Following " . $num_following  . "</b></a></li>";
                echo "<li class='list-group-item'><a href='follower.php?user=" . $user . "'><b>Follower " . $num_follower  . "</b></a></li>";
            ?>
        </ul>
        <?php if($equals){
          echo '<p><a class="btn btn-primary" href="changedata.php?">Edit profile</a></p>';
        }else{
          if(!empty($current_user)){
            if(!$follows->num_rows){
              echo '<p><button id="unfollow" style="display: none" type="button" class="btn btn-primary">Unfollow</button></p>';
              echo '<p><button id="follow" type="button" class="btn btn-primary">Follow</button></p>';
            }
            else{
              echo '<p><button id="unfollow" type="button" class="btn btn-primary">Unfollow</button></p>';
              echo '<p><button id="follow" style="display: none" type="button" class="btn btn-primary">Follow</button></p>';
            }
          }
        }
        ?>
      </div>
    </div>
  </div>

  <!--Albums List-->
  <div class="col-md-8">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Albums</h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <?php
            if($albums->num_rows):
              while($album = $albums->fetch_object()): ?>
                <div class="col-sm-4">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <a href='../gallery/album_page.php?album=<?php echo $album->id; ?>'>
                        <img class="img-responsive img-rounded" src='<?php
                                    if($album->cover==null){
                                      echo "../google-login/images/photo-machine.png";}
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
              <?php endwhile;
            else: ?>
                <div class="col-sm-12">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <h4 class = 'text-center'>No albums to show</h4>
                    </div>
                  </div>
                </div>
            <?php  endif; ?>
            </div>
            <?php if($equals){
              echo '<a href="../gallery/gallerychoose.php" class="btn btn-primary">Create album</a>';
            }
            ?>
            <a href="../gallery/index_albums.php?user=<?php echo $user; ?>" class="btn btn-primary pull-right">Show all albums</a>
          </div>
        </div>
      </div>
    </div>
<!-- Photo Grid -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Photos</h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <?php if($photos->num_rows):
          while($photo = $photos->fetch_object()): ?>
            <div class="col-sm-4">
              <div class="panel panel-default">
                <div class="panel-body">
                  <a href="../gallery/photo_page.php?photo_id=<?php echo $photo->id?>">
                    <img style="height:200px" class="center-block img-responsive img-rounded" src="<?php echo "/uploads/".$photo->name ?>" alt="Immagine">
                  </a>
                </div>
                <table class="table">
                  <ul class="list-group">
                    <li class="list-group-item text-center"><h4><?php echo $photo->description ?></h4></li>
                    <li class="list-group-item text-center">
                      <a href="https://plus.google.com/share?url=http%3A%2F%2Flocalhost%3A8000%2Fphoto_page%2Fcomments.php%3Fphoto_id%3D<?php echo $photo->id; ?>&amp"
                        class="btn btn-danger" aria-hidden="true"
                        target="_blank">Share on G+</a>
                      <a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Flocalhost%3A8000%2Fphoto_page%2Fcomments.php%3Fphoto_id%3D<?php echo $photo->id; ?>&amp"
                        class="btn btn-primary" aria-hidden="true"
                        target="_blank">Share on Facebook</a>
                  </li>
                  </ul>
                </table>
              </div>
            </div>
        <?php endwhile;
      else: ?>
          <div class="col-sm-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <h4 class = 'text-center'>No photos to show</h4>
              </div>
            </div>
          </div>
      <?php  endif; ?>
      </div>
    </div>
  </div>
</div>
<script>
  $('#follow').click(function() {
    var current_user = <?php echo $current_user ?>;
    var user = <?php echo $user ?>;
    $.ajax({
      type: 'POST',
      url: 'follow.php',
      data:
      { current_user: current_user,
        user: user },
      success: function(response) {
        console.log(response);
      }
    });
    $( '#follow' ).hide();
    $( '#unfollow' ).show();
  });
  $('#unfollow').click(function() {
    var current_user = <?php echo $current_user ?>;
    var user = <?php echo $user ?>;
    $.ajax({
      type: 'POST',
      url: 'unfollow.php',
      data:
      { current_user: current_user,
        user: user },
      success: function(response) {
        console.log(response);
      }
    });
    $( '#unfollow' ).hide();
    $( '#follow' ).show();
  });
</script>
</body>
</html>
