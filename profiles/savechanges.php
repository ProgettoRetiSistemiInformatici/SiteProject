<?php
<<<<<<< HEAD
require '../initialization/dbconnection.php';

session_start();

$newBirth;
$Birthsql;
$newFirstName;
$newLastName;
$imagename;

$profileId=$_SESSION['profile']->id;

if(isset($_POST['newBirth'])){
    $newBirth = $_POST['newBirth'];
    if($newBirth == null)
        $newBirth=$_SESSION['profile']->birth;
=======
include '../dbconnection.php';

session_start();

if(isset($_POST['newEmail'])){
    $newEmail = $_POST['newEmail'];
   if($newEmail==null)
    $newFirstName=$_SESSION['profile']->email;
}
if(isset($_POST['newBirth'])){
    $newBirth = $_POST['newBirth'];
    if($newBirth == null){
        $newBirth=$_SESSION['profile']->birth;
    }
>>>>>>> c4e8eed04fa369e772f4e2be70136ba753273096
}
if(isset($_POST['newName'])){
    $newFirstName = $_POST['newName'];
   if($newFirstName==null)
    $newFirstName=$_SESSION['profile']->firstname;
}
<<<<<<< HEAD
if(isset($_POST['newEmail'])){
    $newEmail = $_POST['newEmail'];
   if($newEmail==null)
    $newEmail=$_SESSION['profile']->email;
}
=======
>>>>>>> c4e8eed04fa369e772f4e2be70136ba753273096
if(isset($_POST['newLName'])){
    $newLastName = $_POST['newLName'];
    if($newLastName == null)
    $newLastName = $_SESSION['profile']->lastname;
}
<<<<<<< HEAD
if(isset($_POST['aboutMe'])){
    $newDesc=$_POST['aboutMe'];
    if($newDesc == null)
    $newDesc = $_SESSION['profile']->descuser;
}

if(isset($_FILES['newPimage'])&& $_FILES['newPimage']['size'] != 0){
        $MAXDIM = 10000000;
        $target_dir="profile_images/";
        $imagename = $_FILES["newPimage"]["name"];
        $target_file = $target_dir . basename($imagename);
=======

if(isset($_POST['newPimage'])&& $_POST['newPimage']['size'] != 0){
        $MAXDIM = 10000000;
        $target_dir="profile_images/";
        $name = $_FILES["newPimage"]["name"];
        $target_file = $target_dir . basename($name);
>>>>>>> c4e8eed04fa369e772f4e2be70136ba753273096
        $tmpName = $_FILES["newPimage"]["tmp_name"];
        $uploadOk = 1;

    if($_FILES['newPimage']['error'] !== 0){
<<<<<<< HEAD
        die('An error ocurred when uploading.'. print_r($_FILES['newPimage']));
=======
        die('An error ocurred when uploading.');
>>>>>>> c4e8eed04fa369e772f4e2be70136ba753273096
    }
    $fileName = pathinfo($name, PATHINFO_FILENAME);
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])){
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
    if ($_FILES["newPimage"]["size"] > $MAXDIM ) {
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
<<<<<<< HEAD
        if(!$caricato){
            $error = "Sorry, there was an error uploading your file. ";
            print_r($_FILES);
      }
    }
}
else{
    $imagename= $_SESSION['profile']->profile_image;
}

global $mysqli;
$Birthsql = date('Y-m-d',strtotime($newBirth));
if(!$mysqli->query("UPDATE users SET descuser='$newDesc', profile_image ='$imagename', email='$newEmail', firstname ='$newFirstName', lastname ='$newLastName', birth ='$Birthsql' WHERE id='$profileId';")){
    die($mysqli->error);
    $error = "error in mysql!";
}
header("Location: profile.php?user=".$_SESSION['profile']->name);
=======

    }
}
else{
    $_POST['newPimage']=$_SESSION['profile']->profile_image;
}
$imagename = $_POST['newPimage'];
global $mysqli;
$Birthsql = date('Y-m-d',strtotime($newBirth));
if(!$mysqli->query("UPDATE users SET profile_image ='$imagename', firstname ='$newFirstName', lastname ='$newLastName', birth ='$Birthsql' WHERE id='$profileId';")){
    die($mysqli->error);
    $error = "error in mysql!";
}

header("Location: profile.php?user=".$_SESSION['utente']);
>>>>>>> c4e8eed04fa369e772f4e2be70136ba753273096

session_write_close();

?>
