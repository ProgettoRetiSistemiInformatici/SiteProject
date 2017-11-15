<?php 
include ("../dbconnection.php");

session_start();

global $mysqli;
$galleryitems = $_POST['galleryitem'];
$_SESSION['titlealbum']=$_POST['title'];
$final;
$query = "SELECT name, id from photo ";
$queryfinal;
$ids;
$i=0;
while($i<sizeof($galleryitems)){
    $final.= $galleryitems[$i]."|";
    $i++;
}
function tokenize($str, $token_symbols) {
    $word = strtok($str, $token_symbols);
    global $query, $queryfinal;
    $queryfinal.=$query;
    $queryfinal.= "WHERE name= '$word'";
    $word= strtok($token_symbols);
    while (false !== $word) {
        $queryfinal.=" OR name='$word';";
        $word = strtok($token_symbols);
    }
}
tokenize($final,"|");

if(!$result = $mysqli->query($queryfinal)){
    die($mysqli->error);
}

$mysqli->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Create Album</title>
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
        .button {
            background-color: blue;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 8px;
        }
        .button1{
            background-color: #f44336;
        }
        .button:hover{
           color: blanchedalmond;
        }
        </style>
    </head>
    <body>
        <header>
            <h1><b>PHOTOLIO</b></h1>
        <p><b>A site for photo sharing</b></p>
        </header>
        <p align="left" style="font-family: monospace; font-size: 12px; padding-left: 5px; padding-bottom: 10px;">Are you sure to create this Album?<br></p>
        <div class="container" style="margin-top: 150px">
            <div class="row justify-content-center">
                <div class="col-md-6 col-offset-3" align="center">
                    <a href="createalbum.php"><button class="button">Yes</button></a>
                    <a href="gallerychoose.php?user=<?php echo $_SESSION['utente'];?>"><button class="button button1">No</button></a>
                </div>
            </div>
        </div>
        <div><?php 
        
        while($obj= $result->fetch_object()){    
        ?>
        <div class="gallery">
            <img src="../uploads/<?php echo  $obj->name; ?>" alt="Immagine" width="300" height="200">
        </div>
        <?php $ids.= $obj->id."|";
               }?>
        </div>
    </body>
</html>
<?php
$_SESSION['ids'] = $ids;

session_write_close();

?>