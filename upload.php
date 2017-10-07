<?php
//include ('MySession.php');

include('dbconnection.php');

session_start();

global $name;
global $target_file;
global $error;
global $uploadOk;
$fname = $_POST["newName"];
$target_dir = "uploads/";
if ($fname == null) {
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$name = basename($_FILES["fileToUpload"]["name"]);
}
else {
$target_file = $target_dir . $fname;
$name = $fname;
}
$uploadOk = 1;

if($_FILES['fileToUpload']['error'] > 0){
    die('An error ocurred when uploading.');
}
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
//non permette l'Upload di alcuni tipi di file
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    die("Solo immagini con estensioni JPG, PNG e JPEG sono ammessi.". $imageFileType);
    $uploadOk = 0;
    
}


// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $error = "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $error = "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if (1000000 < $_FILES["fileToUpload"]["size"] ) {
    $error = "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    die("Sorry, your file was not uploaded.");
    }
// if everything is ok, try to upload file
else {
    $caricato = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    if($caricato){
        global $mysqli;
        $user = $_SESSION["utente"];
        $mysqli->real_escape_string($user);
        $mysqli -> real_escape_string($name);
        $query = "INSERT INTO photo (nome, user) VALUES('$name', '$user');";
         if(!$mysqli->query($query)){
            die($mysqli->error);
            $error = "error in mysql!";
            }
    }
      else{ 
        $error = "Sorry, there was an error uploading your file.";
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
