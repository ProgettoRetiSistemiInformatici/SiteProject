<?php
    include('dbconnection.php');

    session_start();
    global $photo;

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if($_GET['photo']!= null){
        $photo = $_GET['photo'];
        $photo = filter_var($photo, FILTER_SANITIZE_STRING);
        $_SESSION['photo'] = $photo;

        }

    else {$photo = $_SESSION['photo'];

    }

    $mysqli;
    $query = "SELECT name, description, rate, votes FROM photo WHERE name = ('$photo');";
    if(!$result = $mysqli -> query($query)){
        echo "Errore nella query";
    }
    $obj = $result -> fetch_object();
    $desc = $obj-> description;
    $rate = $obj -> rate;
    $views = $obj -> votes;
    if($views>0)
     $finalrate = $rate/$views;
    else
     $finalrate = 0;

    $query = "SELECT user, text FROM comments WHERE photo = ('$photo');";
    if(!$comments = $mysqli -> query($query)){
      echo "errore nella query";
    }

   $mysqli -> close();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8" >
        <meta property="og:url"           content="http://www.photolio.com/" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="Photolio" />
        <meta property="og:description"   content="Enter the artistic photos world!" />
        <meta property="og:image"         content="<?php echo "/uploads/".$photo; ?>" />
        <title>Comments - <?php echo $photo; ?></title>
        <meta charset = "UTF-8" >
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <style>
            div.page{
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
                text-align:center;
            }
            div.image{
                margin-top: 5px;
                border: 1px solid #ccc;
                width: 100%;
                text-align:center;
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
                text-align:center;
                width: 25%;
            }
            div.comment textarea{
                width: 100%;
                height: 100px;
            }
            div.rate{
                text-align: center;
                padding-left: 15px;
                font-family: "Courier New", Courier, monospace;
            }
        </style>
        <script src="https://apis.google.com/js/platform.js" async defer>
          {lang: 'en-GB'}
        </script>
    </head>
    <body>
        <header>
            <h1><b>PHOTOLIO</b></h1>
            <p><b>A site for photo sharing</b></p>
        </header>

        <!-- Menu -->
        <?php include 'menu.php' ?>

        <!-- Photo Div -->
        <div class="page">
            <div class="image">
                <img src="<?php echo "/uploads/" .$photo; ?>" alt="Immagine" width="300" height="200">
                <div class="desc"><?php echo $obj->description; ?> | Rating: <?php echo $finalrate ?>/5</div>
            </div>
            <div class="comment">
              <p>Share on G+:</p> <div class="g-plus" data-action="share"
                data-height="24" data-href="<?php echo "http://photolio.com/fotopage.php?photo=". $photo ?>">
              </div>
              <p>Commenti:</p>
              <?php
                if($comments->num_rows){
                  while($obj = $comments -> fetch_object()){
                    echo "<p><b>" . $obj->user . "</b>: " . $obj->text . "</p><br>";
                  }
                }
                else {
                  echo "<p>No comments yet. Be the first one to comment!!</p>";
                } ?>
              <form method="post" action="/saveComment.php">
                  <textarea name="comment" rows="20" cols="50" maxlength="200" placeholder="Type something here..."></textarea>
                  <p>Rate this photo: </p>
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
