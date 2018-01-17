<?php
require '../initialization/dbconnection.php';
require '../profiles/tokenize.php';

session_start();

global $mysqli;
$galleryitems = $_POST['galleryitem'];
$_SESSION['title']=$_POST['title'];
$cover =$_POST['cover'];
$final;

$ids;
$i=0;
while($i<sizeof($galleryitems)){
    $final.= $galleryitems[$i]."|";
    $i++;
}
$queryfinal="SELECT name, id FROM photo ";
$queryfinal .= tokenizenames($final,"|");

if(!$result = $mysqli->query($queryfinal)){
    die($mysqli->error);
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
    <?php include '../shared/header.php'; ?>
    <!-- Menu -->
    <?php include '../shared/menuProfile.php'; ?>
    <form action="createalbum.php">
      <div class="panel panel-default">
        <div class="panel-body bg-danger">
          <div class="row">
            <div class="col-md-6">
              <h3>Do you really want to create this album?</h3>
            </div>
            <div class="col-md-6">
              <div class="pull-right" style="margin-top: 16px">
                <button type="submit" class="btn btn-primary">Yes</button>
                <a href='<?php echo "../profiles/profile.php?user=" . $_SESSION['current_user']; ?>' class="btn btn-danger">No</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="row">
          <?php /*Fetch object array */
            while($obj = $result->fetch_object()){ ?>
              <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                  <img class="img-responsive img-rounded" src="<?php echo "/uploads/".$obj->name ?>" alt="Immagine">
                </div>
              </div>
          <?php $ids .= $obj->id . "|";
          } ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<?php
$_SESSION['ids'] = $ids;
$_SESSION['cover'] = $cover;
session_write_close();

?>
