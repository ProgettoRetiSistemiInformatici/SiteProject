<?php
require '../initialization/dbconnection.php';

$current_user = $_SESSION['current_user'];

$query = "SELECT * FROM photo WHERE user_id = '$current_user';";

if(!$photos = $mysqli->query($query)){
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
      if($photos->num_rows):
    ?>

    <form id="formfield" action="delete.php" method="post">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <h3>Select the photo or photos that you want to delete:</h3>
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
          while($photo = $photos->fetch_object()): ?>
            <div class="col-sm-4">
              <div class="panel panel-default">
                <div class="panel-body">
                  <a href="../photo_page/comments.php?photo_id=<?php echo $photo->id?>">
                    <img style="height:200px" class="center-block img-responsive img-rounded" src="<?php echo "/uploads/".$photo->name ?>" alt="Immagine">
                  </a>
                </div>
                <table class="table">
                  <ul class="list-group">
                    <li class="list-group-item text-center"><h4><?php echo $photo->title ?></h4></li>
                    <li class="list-group-item">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="photos[]" value="<?php echo $photo->id?>">Add to trash</input>
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
            <h4 class = 'text-center'>You haven't uploaded any photo yet!!</h4>
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
          Are you sure you want to delete this photos?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
          <a href="#" id="submit" class="btn btn-danger">Yes</a>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php include 'shared/footer.php'; ?>
<script>

$('#submit').click(function(){
   /* when the submit button in the modal is clicked, submit the form */
  $('#formfield').submit();
});
</script>
</body>
</html>
