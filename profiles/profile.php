<?php

include ('dbconnection.php');

session_start();
$name = $_GET['user'];

global $mysqli;
$query = "SELECT * from users where name= '$name';";
$query .= "SELECT name, description from photo where user ='$name';";
$obj;
if ($mysqli->multi_query($query)){
    if($result = $mysqli->store_result())
        //Store first query result(profile info)
        $obj = $result->fetch_object();
    while($mysqli->next_result()){
        $resultfoto= $mysqli->store_result();
    }
    
}
$mysqli->close();
$date_from_sql = $obj->birth;
$date_right = date('d-m-Y',strtotime($date_from_sql));
session_write_close();

?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
<head>
<title><?php echo $obj->name;?>'s Profile</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<style>
    div.profile_img{
        margin: left;
        border: 5px cyan;
        padding: 10px;
    }
    div.profile_info{
        margin:left;
        border: 1px lightgray;
        padding: 5px;
        font-size: 8px;
    }
ul {
    position: -webkit-sticky;
    position: sticky;
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
</style>
</head>
<body>

<header>
  <h1><b>PHOTOLIO</b></h1>
  <p><b>A site for photo sharing</b></p>
  <p>Hi, <?php echo $obj->name;?></p>
</header>
<!-- Profile Info -->
<div class="profile_img"><img src="<?php echo "profile_images/". $obj->profile_image;?>" width="75" height="75"></div>
<div class="profile_info">
    Nome e Cognome:<?php echo $obj->firstname." ".$obj->lastname;?><br>
    Email: <?php echo $obj->email;?><br>
    Birth Date : <?php echo $date_right;?>
</div>
<!-- Menu -->
<ul>
  <li><a href="<?php echo "/home.php?user=" .$_SESSION["utente"] ?>" >Home</a></li>
  <li><a href="../uploadFile.html">Load Image</a></li>
  <li><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fphotolio.com%2F&amp;src=sdkpreparse">Share Us</a></li>
  <li><a href="logOut.php">Log Out</a></li>
</ul>

<!-- Photo Grid -->
<div><?php /*Fetch object array */
    while($foto = $resultfoto->fetch_object()){ ?>
      <div class="gallery">
        <a href="http://photolio.com/comments.php?photo=<?php echo $foto->name?>"> 
          <img src="<?php echo "../uploads/". $foto->name; ?>" alt="Immagine" width="300" height="200">
        </a>
         <div class="desc"> <?php echo $foto->description ?> |<div class="g-plus" data-action="share" data-height="24" 
                      data-href="<?php echo "http://photolio.com/fotopage.php?photo=". $foto->name ?>"></div>
        </div>
      </div>
    <?php } ?>
</div>
<script src="https://apis.google.com/js/platform.js" async defer>
  {lang: 'en-GB'}
</script>
</body>
</html>

</html>
