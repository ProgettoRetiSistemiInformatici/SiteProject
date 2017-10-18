<?php
    include('dbconnection.php');
    
    session_start();
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    $photo = $_GET['photo'];
    
    $_SESSION['photo'] = $photo;
    
    $mysqli;
    $query = "SELECT name, description, rate, votes FROM photo WHERE name = ('$photo');";
    if(!$result = $mysqli -> query($query)){
        echo "Errore nella query";
    }
    $obj = $result -> fetch_object();
    $mysqli -> close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Comments - <?php echo $photo; ?></title>
        <meta charset = "UTF-8" >
        <style>
            div.page{
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }
            div.image{
                margin-top: 5px;
                border: 1px solid #ccc;
                width: 25%;
                float: left;
            }
            div.image img{
                width: 100%;
                height: auto;
            }
            div.desc{
                padding: 15px;
                text-align: center;
            }
            div.comment{
                margin-top: 5px;
                width: 25%;
                float:left;
            }
            div.comment textarea{
                width: 100%;
                height: auto;   
            }
        </style>
    </head>
    <body>
        <div class="page">
            <div class="image">
                <img src="<?php echo "/uploads/" .$photo; ?>" alt="Immagine" width="300" height="200">
                <div class="desc"><?php echo $obj->description; ?></div>
            </div>
            <div class="comment">
                <form method="post" action="/saveComment.php">
                    <textarea name="comment" rows="20" cols="50" maxlength="200" required placeholder="Type something here..."></textarea>
                    <input type="submit">
                </form>
            </div>
        </div>
    </body>
</html>