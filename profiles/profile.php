<?php

include ('../dbconnection.php');

session_start();
$name = $_SESSION['utente'];

$date_right;
global $mysqli;
$query = "SELECT * FROM users WHERE name= '$name';";
$query .= "SELECT name, description FROM photo WHERE user ='$name';";
$obj;
if ($mysqli->multi_query($query)){
    if($result = $mysqli->store_result())
        //Store first query result(profile info)
        $obj = $result->fetch_object();
    while($mysqli->next_result()){
        $resultfoto= $mysqli->store_result();
    }

}
$_SESSION['profile'] = $obj;
$mysqli->close();
$date_from_sql = $obj->birth;
if($date_from_sql != null)
 $date_right = date('d-m-Y',strtotime($date_from_sql));
session_write_close();

?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $obj->name;?>'s Profile</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<meta charset="UTF-8">
<style>
    div.profile_img{
        margin: left;
        border: 5px blue;
        padding: 10px;
    }
    div.profile_info{
        margin:left;
        border: 1px solid lightgray;
        padding: 5px;
        width: 200px;
        font-size: 10px;
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
    Nome e Cognome:<?php echo  $obj->firstname." ".$obj->lastname;?><br>
    Email: <?php echo $obj->email;?><br>
    Birth Date : <?php echo $date_right;?><br>
    Level : <?php echo $obj->level; ?><br>
</div>
<!-- Menu -->
<?php include 'menuProfile.php'; ?>

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
