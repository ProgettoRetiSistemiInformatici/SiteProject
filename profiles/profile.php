<?php

require '../initialization/dbconnection.php';
require "tokenize.php";

$user = $_GET['user'];

if($name == $_SESSION['current_user']){
  $current_user = true;
}
else{
  $current_user = false;
}

$date_right;
global $mysqli;
$query = "SELECT * FROM users WHERE id= '$user';";
$query .= "SELECT name, description FROM photo WHERE user_id ='$user';";
$query .= "SELECT * FROM albums WHERE user_id='$user' ORDER BY 'id' DESC LIMIT 3;";
$query .= "SELECT * FROM relations WHERE follower_id = '$_SESSION['current_user']' AND followed_id = '$user';";
$obj;
if ($mysqli->multi_query($query)){
    if($result = $mysqli->store_result()){
        //Store first query result(profile info)
        $profile = $result->fetch_object();
    }
    if($mysqli->next_result()){
        $photo = $mysqli->store_result();
    }
    if($mysqli-> next_result()){
        $albums = $mysqli->store_result();
    }
    if($mysqli->next_result()){
        $follows = $mysqli->store_result();
    }
}

$date_from_sql = $obj->birth;
if($date_from_sql != null){
 $date_right = date('d-m-Y',strtotime($date_from_sql));
}

session_write_close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include '../shared/meta.php' ?>
<script src="https://apis.google.com/js/platform.js" async defer>
  {lang: 'en-GB'}
</script>
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
          <img class="img-responsive img-rounded" src="<?php echo "profile_images/". $profile->profile_image;?>"></h3>
      </div>
      <div class="panel-body">
        <ul class="list-group">
          <?php
                if (!empty($profile->firstname) || !empty($profile->lastname)){
                  echo "<li class='list-group-item'><b>Name:</b> " . $profile->firstname . " " . $obj->lastname . "</li>";
                }
                echo "<li class='list-group-item'><b>Email:</b> " . $profile->email . "</li>";
                echo "<li class='list-group-item'><b>Birth Date:</b> " . $date_right ."</li>";
                echo "<li class='list-group-item'><b>Level:</b> " . $profile->level . "</li>";

                if (!empty($profile->descuser)){
                  echo "<li class='list-group-item'><b>About Me:</b> " . $profile->descuser . "</li>";
                }
            ?>
        </ul>
        <?php if($current_user){
          echo '<p><a class="btn btn-primary" href="changedata.php?">Edit profile</a></p>';
        }
        else{
          if(#follow){
            echo '<p><a class="btn btn-primary" href="unfollow.php?flwd=' . $user . '">Unfollow</a></p>';
          }
          else{
            echo '<p><a class="btn btn-primary" href="follow.php?flwd=' . $user . '">Follow</a></p>';
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
            if(isset($albums)){
              while($ra = $albums->fetch_object()){ ?>
                <div class="col-sm-6 col-md-4">
                  <div class="thumbnail">
                    <a href='#COLLEGARE A SHOW ALBUM'>
                      <img class="img-responsive img-rounded" src='<?php
                      if($ra->cover==null){
                        echo "../google-login/images/album.png";}
                      else {
                        echo "../uploads/".$ra->cover;
                      }?>'></a>
                    <div class="caption">
                      <h3><?php echo $ra->title; ?></h3>
                    </div>
                  </div>
                </div>
              <?php }
              }
              else{
                echo "<p>No albums to show</p>";;
              } ?>
            </div>
            <?php if($current_user){
              echo '<a href="../gallery/gallerychoose.php" class="btn btn-primary">Create album</a>';
            }
            ?>
          </div>
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
  <div class="row">
    <?php $result->data_seek(0); /*Fetch object array */
      while($photo = $photos->fetch_object()){ ?>
    <div class="col-sm-6 col-md-4">
      <div class="thumbnail">
        <a href="../photo_page/comments.php?photo=<?php echo $photo->name?>">
          <img class="img-responsive img-rounded" src="<?php echo "/uploads/".$photo->name ?>" alt="Immagine">
        </a>
        <div class="caption text-center">
          <p><b><?php echo $photo->description ?><b></p>
          <div class="g-plus" data-action="share" data-height="24" data-href="<?php echo "http://photolio.com/photo_page/fotopage.php?photo=". $photo->id ?>">
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
<?php  } ?>
</div>
</body>
</html>
