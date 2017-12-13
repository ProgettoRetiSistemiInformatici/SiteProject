<?php
    require '../initialization/dbconnection.php';

    session_start();
    global $photo;

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if($_GET['photo']!= null){
        $photo = $_GET['photo'];
        $photo = filter_var($photo, FILTER_SANITIZE_STRING);
        $_SESSION['photo'] = $photo;

        }

    else {
        $photo = $_SESSION['photo'];
    }

    global $mysqli;
    $query = "select user, description, (rate/votes) as finalrate from photo where name ='$photo';";
    $query .= "select text, user from comments where photo ='$photo'";
    if(!$mysqli->multi_query($query)){
        die($mysqli->error);
    }
    else{
        $result = $mysqli->store_result();
        $obj =$result->fetch_object();
        $fuser= $obj->user;
        $desc = $obj->description;
        $rate = $obj->finalrate;
        if($rate == NULL){
            $rate = 0;
        }
        if(!$mysqli->next_result()){
            die($mysqli->error);
        }
        $comments = $mysqli->store_result();
    }
    $_SESSION['fotouser'] = $fuser;
   $mysqli -> close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Comments - <?php echo $photo; ?></title>
        <?php include '../shared/header.php' ?>
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
                width: 100%;
                float: left;
            }
            div.image img{
                width: 100%;
                height: auto;
            }
            div.desc {
                padding: 15px;
                text-align: center;
                font-style: italic;
                color: dimgrey;
            }
            div.comment{
                margin-top: 5px;
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
        <?php include '../menu.php'; ?>
    <!-- Photo Div -->
    <div class="page">
            <div class="image">
                <img src="<?php echo "/uploads/" .$photo; ?>" alt="Immagine" class='img-responsive'>
                <div class="desc"><?php echo $desc; ?> | Rating: <?php echo round($rate,2); ?>/5</div>
            </div>
            <div class="comment">
              <p>Share on G+:</p> <div class="g-plus" data-action="share"
                data-height="24" data-href="<?php echo "http://photolio.com/fotopage.php?photo=". $photo ?>">
              </div>
              <p>Commenti:</p>
              <?php
                $result->data_seek(0);
                if($comments->num_rows){
                  while($obj = $comments->fetch_object()){
                    echo "<p><b>" . $obj->user . "</b>: " . $obj->text . "</p><br>";
                  }
                }
                else {
                  echo "<p>No comments yet. Be the first one to comment!!</p>";
                }?>
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
