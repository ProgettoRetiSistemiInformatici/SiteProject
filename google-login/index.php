<?php
<<<<<<< HEAD
  include("../dbconnection.php");
	session_start();
        global $mysqli;
	if (!isset($_SESSION['access_token'])) {
		header('Location: ../google-login/login.php');
		exit();
	}
        else {
            $user = $_SESSION['utente'];
            $query="select name from users where name='$user';";
            if($result= $mysqli->query($query)){
            header('Location: ../home.php?user'.$user);
            }
        }
?>
=======
    require_once "config.php";
   
	if (isset($_SESSION['access_token'])) {
		header('Location: home.php');
		exit();
	}

	$loginURL = $gClient->createAuthUrl();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login With Google</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container" style="margin-top: 150px" align="center">
        <div class="row justify-content-center">
            <div class="col-md-6 col-offset-3" align="center">

                <img src="images/photo-machine.png" class="img-thumbnail"width="100"><br><br>
                <h1><b>PHOTOLIO</b></h1>
                <p><b>A site for photo sharing</b></p>
                <form action="accesso.php" method="post">
                    <input type="text" name="name" class="form-control" placeholder="Username..."><br>
                    <input type="password" placeholder="Password..." name="password" class="form-control"><br>
                    <input type="submit" value="Log In" class="btn btn-primary">
                    <input type="button" onclick="window.location = '<?php echo $loginURL ?>';" value="Log In With Google" class="btn btn-danger">
                </form>

            </div>
        </div>
    </div>
</body>
</html>
>>>>>>> c4e8eed04fa369e772f4e2be70136ba753273096
