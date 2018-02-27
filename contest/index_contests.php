<?php
  require '../initialization/dbconnection.php';


  $guest = false;

  $query = "SELECT * FROM contest ORDER BY 'endtime';";
  if (!$contests = $mysqli->query($query)){
       echo $mysqli->error;
  }

$mysqli->close();

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
        <h3 class="panel-title text-center"><b>All contests</b></h3>
      </div>
      <div class="panel-body">
        <?php if($contests->num_rows):
          while($rc = $contests->fetch_object()): ?>
            <div class="col-sm-4">
              <div class="panel panel-default">
                <div class="panel-body">
                  <a href='../contest/contest_page.php?contest=<?php echo $rc->id; ?>'>
                    <img class="img-responsive img-rounded" src='<?php
                                if($rc->contest_img==null){
                                  echo "../contest/contest_covers/Default.png";}
                                else {
                                  echo "../contest/contest_covers/".$rc->contest_img;
                                }?>'>
                  </a>
                </div>
                <table class="table">
                  <ul class="list-group">
                    <li class="list-group-item text-center"><h4><b><?php echo $rc->name; ?></b></h4></li>
                  </ul>
                </table>
              </div>
            </div>
          <?php endwhile;
        else: ?>
            <div class="col-sm-12">
              <div class="panel panel-default">
                <div class="panel-body">
                  <h4 class = 'text-center'>No contests to show</h4>
                </div>
              </div>
            </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
    <?php include '../shared/footer.php'; ?>
</body>
</html>
