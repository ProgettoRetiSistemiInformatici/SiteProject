<?php
    require_once "config.php";

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

	if (isset($_SESSION['access_token'])) {
		header('Location: ../home.php');
		exit();
	}

	$loginURL = $gClient->createAuthUrl();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../shared/meta.php' ?>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6 col-offset-3 text-center" style="margin-top: 100px">
              <div class="jumbotron">
                <img src="images/photo-machine.png" class="img-thumbnail" width="100"><br><br>
                <form action="access.php" method="post">
                    <div class="form-group">
                        <label for="inputEmail">Username</label>
                        <input type="text" id="inputEmail" name="name" class="form-control" placeholder="Username"><br>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Password</label>
                        <input type="password" id="inputPassword" placeholder="Password" name="password" class="form-control"><br>
                    </div>
                    <input type="submit" value="Log in" class="btn btn-primary">
                </form>
              </div>
            </div>
            <div class="col-md-6 text-center" style="margin-top: 300px">
              <div class="jumbotron">
                <input type="button" onclick="window.location = '<?php echo $loginURL ?>';" value="Log in with Google" class="btn btn-danger">              </div>
            </div>
        </div>
    </div>
</body>
</html>
