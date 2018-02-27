<?php
require '../initialization/dbconnection.php';
$user = $_SESSION['current_user'];
$name = $_POST['name'];
$desc = $_POST['description'];
$desc = $mysqli->real_escape_string($desc);
$name = $mysqli->real_escape_string($name);
 


if(isset($_FILES['groupImage'])&& $_FILES['groupImage']['size'] != 0){
        $MAXDIM = 10000000;
        $target_dir="group_covers/";
        $imagename = $_FILES["groupImage"]["name"];
        $target_file = $target_dir . basename($imagename);
        $tmpName = $_FILES["groupImage"]["tmp_name"];
        $uploadOk = 1;

    if($_FILES['groupImage']['error'] !== 0){
        die('An error ocurred when uploading.'. print_r($_FILES['groupImage']));
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
    if ($_FILES["groupImage"]["size"] > $MAXDIM ) {
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
        if(!$caricato){
            echo "Sorry, there was an error uploading your file. ";
            print_r($_FILES);
      }
    }
}
if($imagename != NULL){
    $query = "INSERT INTO groups (name, description, group_cover, admin) VALUES ('$name,'$desc','$imagename','$user');";
}
else {
    $query = "INSERT INTO groups (name, description, admin) VALUES ('$name','$desc','$user');";
}
if(!$mysqli->query($query)){
    die($mysqli->error);
}

$query2 = "SELECT id FROM groups WHERE name='$name' and description='$desc';";
if(!$result = $mysqli->query($query2)){
    die($mysqli->error);
}
$_SESSION['group_id'] = $result->fetch_object()->id;
$idgroup = $_SESSION['group_id'];
$query3="INSERT INTO membership (group_id, member_id) VALUES ('$idgroup','$user');";
if(!$mysqli->query($query3)){
    die($mysqli->error);
}
$mysqli->close();
$_SESSION['current_user'] = $user;
header('Location: group_page.php');
session_write_close();
?>
