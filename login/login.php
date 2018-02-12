<?php
    require_once "config.php";
    require_once "fb-config.php";

	if (isset($_SESSION['google_token']) || isset($_SESSION['fb_access_token'])) {
		header('Location: ../home.php');
		exit();
	}

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
                <form action="../login/access.php" method="post">
                    <div class="form-group">
                        <label for="inputEmail">Email:</label>
                        <input type="email" id="inputEmail" required name="email" class="form-control" placeholder="Email"><br>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Password:</label>
                        <input type="password" id="inputPassword" required placeholder="Password" name="password" class="form-control"><br>
                    </div>
                    <input type="submit" value="Log in" class="btn btn-primary">
                </form>
              </div>
            </div>
            <div class="col-md-6 text-center" style="margin-top: 300px">
              <div class="jumbotron">
                <input type="button" onclick="window.location = '<?php echo $loginURL ?>';" value="Log in with Google" class="btn btn-danger">
                <input type="button" onclick="window.location = '<?php echo $FBloginUrl ?>';" value="Log in with Facebook" class="btn btn-primary">
              </div>
            </div>
        </div>
    </div>
</body>
</html>
