<?php
require '../initialization/dbconnection.php';

//se non si e' loggati si viene reindirizzati nella pagina di registrazione/login
if(!isset($_SESSION["current_user"])){
    header("Location: /index.php");
}

$current_user = $_SESSION['current_user'];

global $mysqli;

$query = "SELECT * FROM photo WHERE user_id = '$current_user';";

if(!$result = $mysqli->query($query)){
    die($mysqli->error);
    $error = "error in mysql!";
}

$mysqli->close();

?>

<!DOCTYPE html>
<html>
<head>
  <?php include '../shared/meta.php'; ?>
</head>
<body>
  <div class="container">
    <header>
      <?php include '../shared/header.php'; ?>
    </header>
    <!-- Menu -->
    <?php include '../shared/menuProfile.php';
      if($result->num_rows):
    ?>
    <form id="formfield" action="createalbum.php" method="post">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title text-center">New Album</h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="inputTitle">Album title:</label>
                  <input type="text" class="form-control" id="inputTitle" name="title" placeholder="Title" required>
              </div>
            </div>
            <div class="col-md-8">
              <div class="pull-right" style="margin-bottom: 10px">
                <button id="submitBtn" type="button" data-toggle="modal" data-target="#confirm-album" class="btn btn-primary">Accept</button>
                <button type="reset" class="btn btn-default">Reset</button>
              </div>
            </div>
          </div>
          <div class="row">
            <?php /*Fetch object array */
            while($obj = $result->fetch_object()): ?>
              <div class="col-sm-4">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <a href="photo_page/comments.php?photo_id=<?php echo $obj->id?>">
                      <img style="height:200px" class="center-block img-responsive img-rounded" src="<?php echo "/uploads/".$obj->name ?>" alt="Immagine">
                    </a>
                  </div>
                  <table class="table">
                    <ul class="list-group">
                      <li class="list-group-item text-center"><h4><?php echo $obj->title ?></h4></li>
                      <li class="list-group-item">
                        <div class="form-horizontal">
                          <div class="checkbox">
                            <label><input id="addAlbum" type="checkbox" name="galleryitem[]" value="<?php echo $obj->id?>">Add to this album</label>
                          </div>
                          <div class="radio">
                            <label><input id="addCover" type="radio" name="cover" value="<?php echo $obj->name?>">Use as cover</label>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </table>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      </div>
    </form>
  <?php else: ?>
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <h4 class = 'text-center'>You can't create an album, you haven't uploaded any photo yet!!</h4>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="confirm-album" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          Are you sure you want to create this album?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <a href="#" id="submit" class="btn btn-success success">Submit</a>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php include '../shared/footer.php'; ?>
<script>

$('#submit').click(function(){
   /* when the submit button in the modal is clicked, submit the form */
  $('#formfield').submit();
});
</script>
</body>
</html>
