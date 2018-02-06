<?php
  require '../initialization/dbconnection.php';

  $user = $_GET['user'];

  $query = "SELECT login.* FROM login INNER JOIN relations ON relations.follower_id = login.id AND relations.followed_id = '$user';";

  if(!$result = $mysqli->query($query)){
    die("Error on get query!");
  }

?>

<!DOCTYPE html>

<html>
<head>
  <?php include '../shared/meta.php' ?>
</head>
<body>
  <div class="container">

    <?php include '../shared/header.php' ?>
    <!-- Menu -->
    <?php include '../shared/menuProfile.php' ?>

    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-body">
          <?php if($result->num_rows): ?>
            <div class="col-md-6">
            <?php while($profile = $result->fetch_object()): ?>
              <div class="panel panel-default">
                <div class="panel-body">
                  <div class="col-md-4">
                    <img class="img-responsive img-rounded" src="<?php echo "profile_images/". $profile->profile_image;?>"></h3>
                  </div>
                  <div class="col-md-8">
                    <ul class="list-group">
                      <?php
                            if (!empty($profile->firstname) || !empty($profile->lastname)){
                              echo "<li class='list-group-item'><b>Name:</b> " . $profile->firstname . " " . $profile->lastname . "</li>";
                            }
                            echo "<li class='list-group-item'><b>Email:</b> " . $profile->email . "</li>";
                            if(!empty($profile->birth)){
                              $date = date('d-m-Y',strtotime($profile->birth));
                              echo "<li class='list-group-item'><b>Birth Date:</b> " . $date ."</li>";
                            }
                            echo "<li class='list-group-item'><b>Level:</b> " . $profile->level . "</li>";

                            if (!empty($profile->descuser)){
                              echo "<li class='list-group-item'><b>About Me:</b> " . $profile->descuser . "</li>";
                            }
                        ?>
                    </ul>
                  </div>
                  <a href="../profiles/profile.php?user=<?php echo $profile->id ?>" class="btn btn-default pull-right">Show profile</a>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        <?php else:
                echo "<h4 class = 'text-center'>This user doesn't have follower</h4>";
            endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
