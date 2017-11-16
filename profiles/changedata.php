<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Photolio
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <meta charset="UTF-8">
        <style>
            div.profile_img{
                margin: left-bottom;
                border: 5px blue;
                padding: 10px;
            }
            div.profile_info{
                margin: left;
                border: 1px solid lightgray;
                padding: 5px;
                width: 500px;
                font-size: 10px;
            }
        </style>
    </head>
    <body>
        <header>
            <h1><b>PHOTOLIO</b></h1>
            <p><b>A site for photo sharing</b></p>
        </header>
        <!--profile current data -->
        <form action="savechanges.php" method="post" enctype="multipart/form-data">
            <div style="width: 50%; margin: 0 auto;">
              <div class="profile_img">
                <img src="<?php echo "profile_images/".$_SESSION['profile']->profile_image; ?>"
                alt="Immagine "width="75" height="75"> <br>Modifica Immagine del profilo:<input type="file" name="newPimage"><br></div>
                <div align="center" class="profile_info">Email: <?php echo  $_SESSION['profile']->email ?>| Modifica email personale <input type="text" name="newEmail"><br></div>
                <div align="center" class="profile_info">Nome: <?php echo  $_SESSION['profile']->firstname ?>| Modifica dati personali <input type="text" name="newName"><br></div>
                <div align="center" class="profile_info">Cognome: <?php echo  $_SESSION['profile']->lastname ?>| Modifica dati personali <input type="text" name="newLName"><br></div>
                <div align="center" class="profile_info">Data di nascita: <?php echo  date('d-m-Y',strtotime($_SESSION['profile']->birth)) ?>|Modifica dati personali<input type="date" name="newBirth"><br></div>
                <div class="profile_info"><textarea name="aboutMe" rows="10" cols="50" maxlength="200" placeholder="Type something about you..."></textarea>
            </div>
            <div align="right" class="profile_info"><input type="submit"></div>
        </form>
    </body>
</html>
