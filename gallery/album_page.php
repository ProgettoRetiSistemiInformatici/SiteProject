<?php
require '../initialization/dbconnection.php';

$guest = false;

if(empty($_SESSION['current_user'])){
  $guest = true;
}

$album_id = $_GET['album'];

$query = "SELECT albums.id AS album_id, albums.title AS album_title, albums.user_id, (albums.rate/albums.votes) AS rate, photo.id AS photo_id, photo.title AS photo_title, photo.name AS photo_name FROM albums INNER JOIN contents ON albums.id ='$album_id' AND contents.album_id = '$album_id' INNER JOIN photo ON photo.id = contents.photo_id;";

if(!$result = $mysqli->query($query)){
    die($mysqli->error);
}

$rows = $result->num_rows;
if($rows){

  $album = $result->fetch_array(MYSQLI_ASSOC);
  $rate = $album['rate'];

  $photographer_id = $album['user_id'];

  $query = "SELECT firstname FROM login WHERE id = '$photographer_id';";
  $query .= "SELECT comments.comment, login.id, login.email, login.firstname FROM login INNER JOIN comments ON comments.user_id = login.id AND comments.album_id = '$album_id';";
  if ($mysqli->multi_query($query)){
    if($photographer = $mysqli->store_result()){
        $photographer = $photographer->fetch_object();
        $fuser = $photographer->firstname;
    }
    if($mysqli->next_result()){
      $comments = $mysqli->store_result();
    }
  }
}
else{
  $query = "SELECT user_id FROM albums WHERE id = '$album_id';";
  if(!$user_id = $mysqli->query($query)){
    die($mysqli->error);
  }

  $user_id = $user_id->fetch_object()->user_id;
}

$mysqli->close();
session_write_close();

?>
<html>
<head>
    <?php include '../shared/meta.php'; ?>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <?php include '../shared/header.php' ?>
        <!-- Menu -->
        <?php include '../shared/menuProfile.php'; ?>
        <!-- Album's Photo Grid -->
        <?php if($result->num_rows): ?>
          <form action="save_comment.php?album_id=<?php echo $album_id; ?>" method="post">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title text-center"><b>Info</b></h3>
              </div>
              <div class="panel-body">
                <div class="col-md-12 text-center">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <div class="col-md-12 text-center">
                        <h3><b>Creator:</b> <a href="../profiles/profile.php?user=<?php echo $photographer_id; ?>"><?php echo $fuser; ?></a></h3>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="panel panel-default">
                   <div class="panel-body">
                     <a href="https://plus.google.com/share?url=http%3A%2F%2Fphotolio.altervista.org%2Fgallery%2Falbum_page.php%3Falbum%3D<?php echo $album['album_id']; ?>&amp"
                        class="btn btn-danger" aria-hidden="true"
                        target="_blank">G+</a>
                     <a href="https://facebook.com/sharer/sharer.php?u=http%3A%2F%2Fphotolio.altervista.org%2Fgallery%2Falbum_page.php%3Falbum%3D<?php echo $album['album_id']; ?>&amp"
                        class="btn btn-primary pull-right" aria-hidden="true"
                        target="_blank">Facebook</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title text-center"><b>Title: </b><?php echo $album['album_title']; ?></h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <?php do{ ?>
                    <div class="col-sm-4">
                      <div class="panel panel-default">
                        <div class="panel-body">
                          <a href="../gallery/photo_page.php?photo_id=<?php echo $album['photo_id']; ?>">
                            <img style="height:200px" class="center-block img-responsive img-rounded" src="<?php echo "/uploads/".$album['photo_name'] ?>" alt="Immagine">
                          </a>
                        </div>
                        <table class="table">
                          <ul class="list-group">
                            <li class="list-group-item text-center"><p><b><?php echo $album['photo_title'] ?></b></p></li>
                            <li class="list-group-item text-center">
                          <a href="https://plus.google.com/share?url=http%3A%2F%2Fphotolio.altervista.org%2Fgallery%2Fphoto_page.php%3Fphoto_id%3D<?php echo $album['photo_id']; ?>"
                             class="btn btn-danger" aria-hidden="true"
                             target="_blank">G+</a>
                          <a href="https://facebook.com/sharer/sharer.php?u=http%3A%2F%2Fphotolio.altervista.org%2Fgallery%2Fphoto_page.php%3Fphoto_id%3D<?php echo $album['photo_id']; ?>&amp"
                             class="btn btn-primary" aria-hidden="true"
                             target="_blank">Facebook</a>
                            </li>
                          </ul>
                        </table>
                      </div>
                    </div>
                  <?php }while($album = $result->fetch_array(MYSQLI_ASSOC)); ?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading text-center">
                      <h3 class="panel-title text-center"><b>Comments & rating</b></h3>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-12 text-center">
                          <table class="table">
                            <ul class="list-group">
                              <li class="list-group-item">
                                <p><b>Rating:</b> <?php echo round($rate, 2); ?>/5</p>
                              </li>
                              <?php if(!$guest): ?>
                                <li class="list-group-item">
                                  <div class="form-group">
                                    <p><b>Rate:</b></p>
                                    <label class="radio-inline">
                                      <input type="radio" name="rate" id="inlineRadio1" value="1"> 1
                                    </label>
                                    <label class="radio-inline">
                                      <input type="radio" name="rate" id="inlineRadio2" value="2"> 2
                                    </label>
                                    <label class="radio-inline">
                                      <input type="radio" name="rate" id="inlineRadio3" value="3"> 3
                                    </label>
                                    <label class="radio-inline">
                                      <input type="radio" name="rate" id="inlineRadio4" value="4"> 4
                                    </label>
                                    <label class="radio-inline">
                                      <input type="radio" name="rate" id="inlineRadio5" value="5"> 5
                                    </label>
                                  </div>
                                </li>
                              <?php endif; ?>
                            </ul>
                          </table>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <table class="table">
                            <ul class="list-group">
                              <?php if($comments->num_rows){
                                while($obj = $comments->fetch_object()){
                                  echo '<li class="list-group-item">';
                                  if ($obj->firstname != NULL){
                                    echo "<p><b><a href='../profiles/profile.php?user=" . $obj->id . "'>" . $obj->firstname . "</a></b>: " . $obj->comment . "</p></li>";
                                  }
                                  else{
                                    echo "<p><b><a href='../profiles/profile.php?user=" . $obj->id . "'>" . $obj->email . "</a></b>: " . $obj->comment . "</p></li>";
                                  }
                                }
                              }
                              else {
                                echo '<li class="list-group-item">';
                                echo "<p>No comments yet. Be the first one to comment!!</p></li>";
                              }?>
                            </ul>
                          </table>
                        </div>
                        <?php if(!$guest): ?>
                          <div class="col-md-6 text-center">
                            <div class="form-group">
                              <textarea name="comment" id="insertComment" rows="3" class="form-control" placeholder="Comment..."></textarea>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12 text-center">
                              <button class="btn btn-primary" type="submit">Send</button>
                            </div>
                          </div>
                        <?php endif ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <?php else: ?>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-body text-center">
                      <h3>This album is empty.
                      <?php if(!$guest && $user_id == $current_user): ?>
                        You can simply delete this album
                          <a href="../gallery/delete_albums.php">here</a>.
                      <?php endif; ?>
                      </h3>
                    </div>
                  </div>
                </div>
              </div>
            <?php endif; ?>
        </div>
          <?php include 'shared/footer.php'; ?>
    </body>
</html>
