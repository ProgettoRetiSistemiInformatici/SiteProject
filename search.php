<?php

require 'initialization/dbconnection.php';

session_start();
global $mysqli;
$searchterm=$_POST['search'];
$searchtermjpg= $searchterm.".jpg";
$searchtermpng = $searchterm.".png";
$searchtermjpeg =$searchterm.".jpeg";
$query = "SELECT *"
        . " from users where name='$searchterm' or firstname='$searchterm' or lastname='$searchterm';";
$query.= " SELECT * from"
        . "(album join users on users.name = album.user) where users.name='$searchterm' or users.firstname='$searchterm' or users.lastname='$searchterm';";
$query.= "select f.name as foto, f.id, f.description, u.name, u.lastname, u.firstname from
    (photo f join users u on u.name = f.user) where u.lastname ='$searchterm' or u.name ='$searchterm' or u.firstname='$searchterm' order by f.id desc;
";
if (!$mysqli->multi_query($query)){
   die($mysqli->error);
}

if($result = $mysqli->store_result()){
    //Store first query result(profile info)
    $obj = $mysqli->store_result();

}
if($mysqli->next_result()){
    //Store second query result
    $resultalbum= $mysqli->store_result();
}
if($mysqli-> next_result()){
    //Store third query result
 $resultfoto =$mysqli->store_result();
}
$mysqli->close();
session_write_close();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Risultati Ricerca - <?php echo $searchterm; ?></title>
        <?php include 'shared/header.php'; ?>
        <style>
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
            nav {
                float: left;
                max-width: 160px;
                margin: 0;
                padding: 1em;
            }

            nav ul {
                display: block;
                list-style-type: none;
                padding: 0;
                text-align: center;
                text-overflow: ellipsis;
            }
            right {
                float: right;
                max-width: 200px;
                margin: 5px;
                padding: 1em;
            }
            right ul{
                display: block;
                list-style-type: none;
                padding:0;
            }
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
        </style>
    </head>
    <body>
        <header>
        <h1><b>PHOTOLIO</b></h1>
        <p><b>A site for photo sharing</b></p>
        </header>
            <!--Menù -->
            <ul>
            <li><a href="<?php echo "/home.php?user=" .$_SESSION["utente"] ?>" >Home</a></li>
            <li><a href="uploadFile.html">Load Image</a></li>
            <li><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fphotolio.com%2F&amp;src=sdkpreparse">Share Us</a></li>
            <li><a href="google-login/logout.php">Log Out</a></li>
            <li><a href="<?php echo "profiles/profile.php?user=" .$_SESSION["utente"] ?>"><img height="20" width="20"src="profiles/profile_images/<?php echo $_SESSION['profminiature']; ?>"> My Profile</a></li>
            <li><form action="search.php" method="post"><input type="text" name="search" placeholder="Search.."></form></li>
            </ul>
            <!--Album's List-->
            <nav>
                <div class="row">
                    <div class='panel panel-default' style="width: fit-content;">
                        <div class='panel-heading'><p>Related Albums</p>
                            <div class='panel-body'>
                                <div class=" panel panel-default">
                <?php
                    while($ra = $resultalbum->fetch_object()){
                        ?>
                    <div class='panel-heading'><ul><?php  echo $ra->titolo; ?></ul></div>
                    <div class='panel-body' align="center">
                        <a href='profiles/profileview.php?user=<?php echo $ra->user;?>&idS=<?php echo $ra->idFoto;?>&id=<?php echo$ra->id;?>'>
                            <img  class='img-thumbnail' src='<?php if($ra->Cover==null){
                            echo "../google-login/images/album.png";} else {
                            echo "../uploads/".$ra->Cover;
                        }?>' alt='Immagine' height="80" width="80"></a>
                        </div>
                    <?php
                    } ?>        </div>
                            </div>
                        </div>
                   </div>
                </div>

            </nav>
               <!--Profiles List -->
    <right>
            <div class='row'>
                <div class='panel panel-default'>
                    <div class='panel panel-heading'>
                        <ul>Related Profiles:</ul></div>
                <?php while($obj=$result ->fetch_object()){ ?>
                    <div class="profile_img"><a href="/profiles/profileview.php?user=<?php echo $obj->name;?>">
                     <img style="border-radius: 50%; " src="<?php echo "/profiles/profile_images/". $obj->profile_image;?>" width="75" height="75">
                    </a></div>
                <div class="profile_info">
                    Nome e Cognome:<?php echo  $obj->firstname." ".$obj->lastname;?><br>
                    Email: <?php echo $obj->email;?><br>
                    Birth Date : <?php echo $obj->birth;?><br>
                    Level : <?php echo $obj->level; ?>
                </div>
                    <div class="profile_info">
                    About Me: <?php echo $obj->descuser ?>
                    </div>
                </div>
            </div>
    </right>
                <?php } ?>
            <!-- Photo Grid -->
            <article>
                <div class='container'>
                    <?php while($foto = $resultfoto->fetch_object()){?>
                    <div class="gallery">
                      <a href="/comments.php?photo=<?php echo $foto->foto?>">
                        <img src="<?php echo "uploads/".$foto->foto ?>" alt="Immagine" width="300" height="200">
                      </a>
                      <div class="desc"> <?php echo $foto->description ?> |<div class="g-plus" data-action="share" data-height="24"
                                    data-href="<?php echo "http://photolio.com/fotopage.php?photo=". $foto->foto ?>"></div>
                      </div>
                    </div>

                    <?php
                    } ?>
                </div>
            </article>
    <script src="https://apis.google.com/js/platform.js" async defer>
        {lang: 'en-GB'}
    </script>
    </body>
</html>
