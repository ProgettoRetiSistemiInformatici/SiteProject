<?php
  require '../initialization/dbconnection.php';


  $guest = false;

  if(!isset($_SESSION['current_user'])){
    $guest = true;
  }
  else{
    $current_user = $_SESSION['current_user'];
  }
  $user = $_GET['user'];

  $query = "SELECT * FROM albums WHERE user_id='$user' ORDER BY 'id';";
  if (!$albums = $mysqli->query($query)){
       echo $mysqli->error;
  }


?>

<!DOCTYPE html>
<html>
<head><?php include '../shared/meta.php'; ?></head>
<body>
  <div class="container">
    <?php include '../shared/header.php'; ?>
    <?php include '../shared/menuProfile.php'; ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title text-center"><b>Your Albums</b></h3>
      </div>
      <div class="panel-body">
        <?php if($albums->num_rows != 0):
          while($ra = $albums->fetch_object()): ?>
            <div class="col-sm-4">
              <div class="panel panel-default">
                <div class="panel-body">
                  <a href='../gallery/album_page.php?album=<?php echo $ra->id; ?>'>
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
          <?php endwhile;
        else: ?>
            <div class="col-sm-12">
              <div class="panel panel-default">
                <div class="panel-body">
                  <h4 class = 'text-center'>No albums to show</h4>
                </div>
              </div>
            </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>
