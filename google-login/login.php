<?php
    require_once "config.php";
<<<<<<< HEAD

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

	if (isset($_SESSION['access_token'])) {
		header('Location: ../home.php');
=======
   
	if (isset($_SESSION['access_token'])) {
		header('Location: home.php');
>>>>>>> c4e8eed04fa369e772f4e2be70136ba753273096
		exit();
	}

	$loginURL = $gClient->createAuthUrl();
?>
<<<<<<< HEAD

<!DOCTYPE html>
=======
<!doctype html>
>>>>>>> c4e8eed04fa369e772f4e2be70136ba753273096
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login With Google</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
    <div class="container" style="margin-top: 100px">
        <div class="row justify-content-center">
            <div class="col-md-6 col-offset-3" align="center">

                <img src="images/photo-machine.png" class="img-thumbnail"width="100"><br><br>

<<<<<<< HEAD
                <form action="access.php" method="post">
=======
                <form action="accesso.php" method="post">
>>>>>>> c4e8eed04fa369e772f4e2be70136ba753273096
                    <input type="text" name="name" class="form-control" placeholder="Username..."><br>
                    <input type="password" placeholder="Password..." name="password" class="form-control"><br>
                    <input type="submit" value="Log In" class="btn btn-primary">
                    <input type="button" onclick="window.location = '<?php echo $loginURL ?>';" value="Log In With Google" class="btn btn-danger">
                </form>

            </div>
        </div>
    </div>
</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> c4e8eed04fa369e772f4e2be70136ba753273096
