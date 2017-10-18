<?php
//include ('MySession.php');
include('dbconnection.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

global $mysqli;
global $name;
global $target_file;
global $error;
global $uploadOk;

$MAXDIM = 10000000;
$target_dir = "uploads/";
$name = $_FILES["fileToUpload"]["name"];
$target_file = $target_dir . basename($name);
$tmpName = $_FILES["fileToUpload"]["tmp_name"];
$uploadOk = 1;

if($_FILES['fileToUpload']['error'] !== 0){
    die('An error ocurred when uploading.');
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
    if($caricato){
        $user = $_SESSION["utente"];
        $nameExt = basename($name);
        $mysqli -> real_escape_string($user);
        $mysqli -> real_escape_string($nameExt);
        $query = "INSERT INTO photo (name, user) VALUES('$nameExt', '$user');";
         if(!$mysqli->query($query)){
            die($mysqli->error);
            $error = "error in mysql!";
            }
    }
      else{ 
        $error = "Sorry, there was an error uploading your file. ";
        print_r($_FILES);
      }
}

$mysqli->close();
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
		<p style="color: red"><?php echo $error; print_r($_FILES); ?></p>
	<?php else: header('Location: /home.php?user='.$_SESSION['utente']);?>	
	<?php endif ?>
        <?php exit();?>	
</body>
</html>