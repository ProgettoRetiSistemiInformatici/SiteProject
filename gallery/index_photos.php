<?php
  require '../initialization/dbconnection.php';

  $current_user = $_SESSION['current_user'];
  $user = $_GET['user'];

  $query = "SELECT * FROM photo WHERE user_id='$user' ORDER BY 'id';";
  if (!$photos = $mysqli->query($query)){
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
        <h3 class="panel-title text-center"><b>Your Photos</b></h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <?php if($photos->num_rows != 0):
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
                      <li class="list-group-item text-center"><h4><?php echo $photo->title ?></h4></li>
                      <li class="list-group-item text-center">
                        <a href="https://plus.google.com/share?url=http%3A%2F%2Fphotolio.altervista.org%2Fgallery%2Fphoto_page.php%3Fphoto_id%3D<?php echo $photo->id; ?>&amp"
                          class="btn btn-danger" aria-hidden="true"
                          target="_blank">G+</a>
                        <a href="https://facebook.com/sharer/sharer.php?u=http%3A%2F%2Fphotolio.altervista.org%2Fgallery%2Fphoto_page.php%3Fphoto_id%3D<?php echo $photo->id; ?>&amp"
                          class="btn btn-primary" aria-hidden="true"
                          target="_blank">Facebook</a>
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
            <h4 class = 'text-center'>No photo to show</h4>
          </div>
        </div>
      </div>
    <?php  endif; ?>
    </div>
  </div>
</div>
  <?php include '../shared/footer.php'; ?>
</body>
</html>
