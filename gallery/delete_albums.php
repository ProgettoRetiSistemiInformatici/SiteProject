<?php
require '../initialization/dbconnection.php';

//se non si e' loggati si viene reindirizzati nella pagina di registrazione/login
if(!isset($_SESSION["current_user"])){
    header("Location: /index.php");
}

$current_user = $_SESSION['current_user'];

$query = "SELECT * FROM albums WHERE user_id = '$current_user';";

if(!$albums = $mysqli->query($query)){
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
      if($albums->num_rows):
    ?>
    <form id="formfield" action="delete.php" method="post">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <h3>Select the album or albums that you want to delete:</h3>
            </div>
            <div class="col-md-8">
              <div class="pull-right" style="margin-top: 26px">
                <button id="submitBtn" type="button" data-toggle="modal" data-target="#confirm-album" class="btn btn-danger">Delete</button>
                <button type="reset" class="btn btn-default">Reset</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-body">
          <?php
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
                      <li class="list-group-item">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="albums[]" value="<?php echo $ra->id?>">Add to trash</input>
                          </label>
                        </div>
                      </li>
                    </ul>
                  </table>
                </div>
              </div>
            <?php endwhile; ?>
    </form>
  <?php else: ?>
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <h4 class = 'text-center'>You haven't created any album yet!!</h4>
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
          Are you sure you want to delete those albums?
          (photo inside the albums will still be on the site)
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
          <a href="#" id="submit" class="btn btn-danger">Yes</a>
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
