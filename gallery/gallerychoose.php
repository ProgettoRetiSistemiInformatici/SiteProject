<?php
include("../dbconnection.php");
session_start();

$user = $_GET['user'];
$_SESSION['utente'] = $user;
global $mysqli;
if(!$result = $mysqli->query("SELECT name from photo where user= '$user';")){
    die($mysqli->error);
    $error = "error in mysql!";
}

$mysqli->close();

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Photolio - Create Gallery</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>    
    div.gallery {
        margin-top: 5px;
        border: 1px solid #ccc;
        width: 25%;
        float: left;
    }

    div.gallery:hover {
        border: 1px solid #777;
    }

    div.gallery img {
        width: 100%;
        height: auto;
    }

    div.desc {
        padding: 15px;
        text-align: center;
    }
    div.input_checkbox{
        padding-bottom: 10px;
        align-content: center;
        font-family: sans-serif;
    }
    </style>
    </head>
    <body>
        <header>
            <h1><b>PHOTOLIO</b></h1>
            <p><b>A site for photo sharing</b></p>
            <p>Hi, <?php echo $_GET['user'];?><br><p style='color: dodgerblue; font-size: 11px;'>
            Please click on the checkbox to collect photos for the album, enter a title and then it's "done"   
            <p style="font-size: 9px">* type forced</p>
        </header>
        <form action="galleryconfirm.php" method="post">
            Enter title:<input type="text" name="title"/>*
        <input type="submit" value="done">
        <div><?php /*Fetch object array */
            while($obj = $result->fetch_object()){ ?>
      <div class="gallery">
          <img name="<?php echo $obj->name?>" src='../uploads/<?php echo $obj->name ?>' alt="Immagine" width="300" height="200">
         <div class="desc"><div class="g-plus" data-action="share" data-height="24" 
                      data-href="<?php echo "http://photolio.com/fotopage.php?photo=". $obj->name ?>"></div>
         </div><br>
         <div align="center" class="input_radio"><input type="checkbox" name="galleryitem[]" value="<?php echo $obj->name?>"> <input type='radio' value='<?php echo $obj->name; ?>' name='cover'></div>
      </div>
     <?php } ?> 
    </div>
        </form>
    <script src="https://apis.google.com/js/platform.js" async defer>
    {lang: 'en-GB'}
    </script>
    </body>
</html>
