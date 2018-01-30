<?php
require '../initialization/dbconnection.php';
session_start();

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
    <form action="galleryconfirm.php" method="post">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="inputTitle">Album title:</label>
              <input type="text" class="form-control" id="inputTitle" name="title" placeholder="Title" required>
          </div>
        </div>
        <div class="col-md-8">
          <div class="pull-right" style="margin-top: 26px">
            <button type="submit" class="btn btn-primary">Accept</button>
            <button type="reset" class="btn btn-default">Reset</button>
          </div>
        </div>
      </div>
      <div class="row">
        <?php /*Fetch object array */
          while($obj = $result->fetch_object()){ ?>
            <div class="col-sm-6 col-md-4">
              <div class="thumbnail">
                <img class="img-responsive img-rounded" src="<?php echo "/uploads/".$obj->name ?>" alt="Immagine">
                <div class="text-center">
                  <div class="caption">
                    <p><?php echo "<b>" . $obj->description . "</b>"?></p>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="galleryitem[]" value="<?php echo $obj->name?>">Add to this album</input>
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
        <?php } ?>
      </div>
    </form>
  </div>
</body>
</html>
