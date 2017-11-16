<?php
include ('dbconnection.php');
session_start();

global $finalrate;

$foto = $_SESSION['photo'];
$foto = filter_var($foto,FILTER_SANITIZE_STRING);

global $mysqli;
global $obj;
$query ="SELECT rate, votes, description from photo where name = '$foto'";
if(!$result = $mysqli->query($query)){
    die($mysqli->error);
}
else {
    $obj = $result -> fetch_object();
    $rate = $obj -> rate;
    $views = $obj -> votes;
    $finalrate = $rate/$views;
}
?>

<!DOCTYPE html>
<html>
        <head>
            <meta charset="UTF-8">
            <title> Rate this Photo!</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
            <style>
            ul.menu {
                    list-style-type: none;
                    margin: 0;
                    padding: 0;
                    overflow: hidden;
            }
            li {
                    float: left;
            }
            li a {
                    display: block;
                    padding: 8px;
                    background-color: #dddddd;
            }
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
            div.rate{
                text-align: center;
                padding-left: 15px;
                font-family: "Courier New", Courier, monospace;
            }
            </style>
        </head>
        <body>
            <header>
            <h1><b>PHOTOLIO</b></h1>
            <p><b>A site for photo sharing</b></p>
        </header>
            <!-- Menu -->
        <ul class ="menu">
            <li><a href="<?php echo "/index.php" ?>" >Home</a></li>
            <li><a href="#contact">Share Us</a></li>
            <li><a href="signin.html"> Sign In</a></li>
            <li><a href="signup.html"> Sign Up</a></li>
            
        </ul>
            
            <!--Immagine -->
            <div class='page'>
                <div class="image">
                    <img src="<?php echo "uploads/". $foto ?>" alt ="Immagine" height="300" width="200"  ><br>
                        <div class="desc"><?php echo $obj->description; ?></div>
                    </div>
                <div class="comment">
                    <form method="post" action="/saveComment.php">
                         1<input type="radio" name="rate" value="1"/>
                        2<input type="radio" name="rate" value="2"/>
                        3<input type="radio" name="rate" value="3"/>
                        4<input type="radio" name="rate" value="4"/>
                        5<input type="radio" name="rate" value="5"/>
                    
                    <input type="submit">
                    </form>
                    
                </div>
            </div>            
        </body>        
</html>
<?php

session_write_close();
?>