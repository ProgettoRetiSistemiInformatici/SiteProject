<?php
//le foto andranno caricate da database tramite php
include ('dbconnection.php');

session_start();

global $mysqli;
$query = "SELECT name, description FROM photo ORDER BY id LIMIT 6;";
if (!$result = $mysqli->query($query)){
     echo "Errore nella query";
}

$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
<title>Home</title>
<meta charset="UTF-8">

<style>
ul {
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
</header>

<!-- Menu -->
<ul>
  <li><a href="/home.php">Home</a></li>
  <li><a href="uploadFile.html">Load Image</a></li>
  <li><a href="#contact">Share Us</a></li>
  <li><a href="#about">About</a></li>
</ul>

<!-- Photo Grid -->

<div><?php /*Fetch object array */
    while($obj = $result->fetch_object()){ ?>
      <div class="gallery">
        <a target="_blank" href="<?php echo $obj->name ?>">
          <img src="<?php echo "/uploads/".$obj->name ?>" alt="Immagine" width="300" height="200">
        </a>
        <div class="desc"> <?php echo $obj->description ?> </div>
      </div>
    <?php } ?>
</div>

</body>
</html>

