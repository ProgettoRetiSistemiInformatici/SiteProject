
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
</style>

<ul>
  <li><a href="<?php echo "/home.php?user=" .$_SESSION["utente"] ?>" >Home</a></li>
  <li><a href="/load_image/uploadFile.php">Load Image</a></li>
  <li><a href="<?php echo "/profiles/profile.php?user=" . $_SESSION['utente'] ?>" >Profilo</a></li>
  <li><a href="#">Share us on Google+</a></li>
  <li><a href="/google-login/logout.php">Log Out</a></li>
  <li><form action="search.php" method="post"><input type="text" name="search" placeholder="Search.."></form></li>
</ul>
