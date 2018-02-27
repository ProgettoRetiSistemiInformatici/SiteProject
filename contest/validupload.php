<?php
require '../initialization/dbconnection.php';

//se non si e' loggati si viene reindirizzati nella pagina di registrazione/login
if(!isset($_SESSION["current_user"])){
    header("Location: /index.php");
}

$tags = $_POST['tags'];
$_SESSION['tags'] = $tags;

global $name;
global $target_file;
global $error;
global $uploadOk;

$MAXDIM = 10000000;
$target_dir = "../uploads/";
$name = $_FILES["fileToUpload"]["name"];
$target_file = $target_dir . basename($name);
$tmpName = $_FILES["fileToUpload"]["tmp_name"];
$uploadOk = 1;

if($_FILES['fileToUpload']['error'] !== 0){
    die('An error occurred when uploading.');
}
$fileName = pathinfo($name, PATHINFO_FILENAME);
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($tmpName);
    if($check == false){
        $error = "File is not an image.";
        $uploadOk = 0;
    }
    $uploadOk = 1;
}

// Check if file already exists
if (file_exists($target_file)) {

    //Rename the file adding a random number at the end of it
    $rand = rand(1, 9999);
    $name = $fileName . $rand . "." . $imageFileType;
    $target_file = $target_dir . $name;

    $uploadOk = 1;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > $MAXDIM ) {
    $error = "Sorry, your file is too large.";
    $uploadOk = 0;
}

//non permette l'Upload di alcuni tipi di file
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    $error = "Only JPG, PNG and JPEG file admitted. It was a ". $imageFileType;
    $uploadOk = 0;

}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    }
// if everything is ok, try to upload file
else {
    $caricato = move_uploaded_file($tmpName, $target_file);
    $title = $_POST['title'];
    $desc = $_POST["description"];
    if($caricato){
        $current_user = $_SESSION["current_user"];
        $nameExt = basename($name);
        $mysqli -> real_escape_string($current_user);
        $mysqli -> real_escape_string($nameExt);
        $query = "INSERT INTO photo (name, user_id, title, description) VALUES('$nameExt', '$current_user', '$title','$desc');";
        if(!$mysqli->query($query)){
          die($mysqli->error);
          $error = "error in mysql!";
        }
        $_SESSION['photo_id'] = $mysqli->insert_id;

        if(!empty($tags)){
          require 'tagsUpload.php';
        }
        $_SESSION['istr'] = false;
        require '../shared/updateExp.php';
      }
      else{
        $error = "Sorry, there was an error uploading your file. ";
        print_r($_FILES);
      }
      $photo_id = $_SESSION['photo_id'];
      $contest_id = $_SESSION['contest_id'];
      $querycontest = "INSERT INTO photo_contest(photo_id,contest_id) VALUES('$photo_id','$contest_id');";
      if(!$mysqli->query($querycontest)){
          die($mysqli->error);
          $error = "error in mysql!";
        }
}

$mysqli->close();

unset($_SESSION['tags']);
unset($_SESSION['photo']);

session_write_close();
?>

<!DOCTYPE html>
<html>
<head>
	<title> Upload result </title>
</head>
<body>
	<h1>Risultati caricamento immagine</h1>
	<?php if ($error): ?>
		<p style="color: red"><?php echo $error; print_r($name); ?></p>
	<?php else: header('Location: /home.php'); ?>
	<?php endif ?>
        <?php exit();?>
</body>
</html>
