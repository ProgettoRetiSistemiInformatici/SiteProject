<?php
    include('dbconnection.php');
    
    session_start();
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    $photo = $_GET['photo'];
    $photo = filter_var($photo, FILTER_SANITIZE_STRING);
    
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
        <meta property="og:url"           content="http://localhost/" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="Photolio" />
        <meta property="og:description"   content="Enter the artistic photos world!" />
        <meta property="og:image"         content="<?php echo "/uploads/" .$photo; ?>" />
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
        </style>
    </head>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/it_IT/sdk.js#xfbml=1&version=v2.10&appId=1936240010034928';
      fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
    <body>
        <header>
            <h1><b>PHOTOLIO</b></h1>
            <p><b>A site for photo sharing</b></p>
        </header>
        
        <!-- Menu -->
        <ul class="menu">
            <li><a href="<?php echo "/home.php?user=" .$_SESSION["utente"] ?>" >Home</a></li>
            <li><a href="uploadFile.html">Load Image</a></li>
            <li><a href="#contact">Share Us</a></li>
            <li><a href="logOut.php">Log Out</a></li>
        </ul>
        
        <!-- Photo Div -->
        <div class="page">
            <div class="image">
                <img src="<?php echo "/uploads/" .$photo; ?>" alt="Immagine" width="300" height="200">
                <div class="desc"><?php echo $obj->description; ?></div>
            </div>
            <div class="comment">
                <form method="post" action="/saveComment.php">
                    <textarea name="comment" rows="20" cols="50" maxlength="200" placeholder="Type something here..."></textarea>
                    <sel>
                        1<input type="radio" name="rate" value="1"/>
                        2<input type="radio" name="rate" value="2"/>
                        3<input type="radio" name="rate" value="3"/>
                        4<input type="radio" name="rate" value="4"/>
                        5<input type="radio" name="rate" value="5"/>
                    </sel>
                    <input type="submit"
                    <div class="fb-share-button" data-href="<?php echo "/fotopage.php?photo=" .$photo?>"
                         data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank"
                     href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Condividi</a>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
