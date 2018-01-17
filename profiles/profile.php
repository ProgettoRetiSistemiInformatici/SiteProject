<?php

require '../initialization/dbconnection.php';
require "tokenize.php";

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
$query .= "SELECT id, name, description FROM photo WHERE user_id = '$user';";
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
}

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
            if($follows->num_rows){
              echo '<p><a class="btn btn-primary" href="unfollow.php?flwd=' . $profile->id . '">Unfollow</a></p>';
            }
            else{
              echo '<p><a class="btn btn-primary" href="follow.php?flwd=' . $profile->id . '">Follow</a></p>';
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
            if($albums->num_rows){
              while($ra = $albums->fetch_object()){ ?>
                <div class="col-sm-4">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <a href='#COLLEGARE A SHOW ALBUM'>
                        <img class="img-responsive img-rounded" src='<?php
                                    if($ra->cover==null){
                                      echo "../google-login/images/album.png";}
                                    else {
                                      echo "../uploads/".$ra->cover;
                                    }?>'>
                      </a>
                    </div>
                    <table class="table">
                      <ul class="list-group">
                        <li class="list-group-item text-center"><h4><b><?php echo $ra->title; ?></b></h4></li>
                      </ul>
                    </table>
                  </div>
                </div>
              <?php }
              }
              else{ ?>
                <div class="col-sm-12">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <h4 class = 'text-center'>No albums to show</h4>
                    </div>
                  </div>
                </div>
            <?php  } ?>
            </div>
          </div>
          <table class="panel-body">
            <ul class="list-group">
              <li class="list-group-item">
              <?php if($equals){
                echo '<a href="../gallery/gallerychoose.php" class="btn btn-primary">Create album</a>';
                echo '<a href="../gallery/index_albums.php?user=<?php echo $user; ?>" class="btn btn-primary pull-right">Show albums</a></li>';
              }
              else{
                echo '<a href="../gallery/index_albums.php?user=<?php echo $user; ?>" class="btn btn-primary">Show albums</a></li>';
              }
              ?>
            </ul>
          </table>
        </div>
      </div>
    </div>

<!--Follow List -->
    <?php if(isset($_GET['flist']) && $_GET['flist'] = 1){ ?>
        <?php while($flist = $follows->fetch_object()){ ?>
        <div class="gallery">
            <a href="profileview.php?user=<?php echo $flist->name; ?>">
                <img class="img-responsive img-rounded"  src="<?php echo "profile_images/". $flist->profile_image;?>" alt="Immagine Profilo" style ='width: 100%;' >
            </a>
            <div class="desc"> <?php echo $flist->name; ?></div>
        </div>
           <?php } ?>
    </div>
    <?php } else { ?>

<!-- Photo Grid -->
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="row">
        <?php $result->data_seek(0); /*Fetch object array */
          while($photo = $photos->fetch_object()){ ?>
            <div class="col-sm-4">
              <div class="panel panel-default">
                <div class="panel-body">
                  <a href="photo_page/comments.php?photo_id=<?php echo $photo->id?>">
                    <img style="height:200px" class="center-block img-responsive img-rounded" src="<?php echo "/uploads/".$photo->name ?>" alt="Immagine">
                  </a>
                </div>
                <table class="table">
                  <ul class="list-group">
                    <li class="list-group-item text-center"><p><b><?php echo $photo->description ?></b></p></li>
                    <li class="list-group-item"><div class="g-plus" data-action="share" data-height="24" data-href="<?php echo "http://photolio.com/photo_page/fotopage.php?photo=". $photo->id ?>"></div>
                      <div class="fb-share-button pull-right" data-href="http://localhost:8000/photo_page/comments.php?photo_id=<?php echo $photo->id; ?>" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Flocalhost%3A8000%2Fphoto_page%2Fcomments.php%3Fphoto_id%3D<?php echo $photo->id; ?>&amp;src=sdkpreparse">Condividi</a></div></li>
                  </li>
                  </ul>
                </table>
              </div>
            </div>
        <?php } ?>
      </div>
    </div>
  </div>
<?php  } ?>
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
