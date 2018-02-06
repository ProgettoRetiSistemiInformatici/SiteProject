<?php
require '../initialization/dbconnection.php';

//se non si e' loggati si viene reindirizzati nella pagina di registrazione/login
if(!isset($_SESSION["current_user"])){
    header("Location: /index.php");
}

$current_user = $_SESSION['current_user'];

global $mysqli;

$query = "SELECT id, name, description FROM photo WHERE user_id = '$current_user';";

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
    <?php include '../shared/menuProfile.php'; ?>
    <form id="formfield" action="createalbum.php" method="post">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="inputTitle">Album title:</label>
              <input type="text" class="form-control" id="inputTitle" name="title" placeholder="Title" required>
          </div>
        </div>
        <div class="col-md-8">
          <div class="pull-right" style="margin-top: 26px">
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
                  <li class="list-group-item text-center"><h4><?php echo $obj->description ?></h4></li>
                </ul>
              </table>
              <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="galleryitem[]" value="<?php echo $obj->id?>">Add to this album</input>
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="cover" value="<?php echo $obj->name?>">Use as cover</input>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        <?php endwhile; ?>
      </div>
    </form>
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
<script>

$('#submit').click(function(){
   /* when the submit button in the modal is clicked, submit the form */
  $('#formfield').submit();
});
</script>
</body>
</html>
