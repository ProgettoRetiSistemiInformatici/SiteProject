<html>
<head>
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
</head>
<body>
<ul>
  <li><a href="<?php echo "/home.php?user=" .$_SESSION["utente"] ?>" >Home</a></li>
  <li><a href="uploadFile.html">Load Image</a></li>
  <li><a href="<?php echo "/profiles/profile.php?user=" . $_SESSION['utente'] ?>" >Profilo</a></li>
  <li><a href="#">Share us on Google+</a></li>
  <li><a href="/google-login/logout.php">Log Out</a></li>
</ul>
</body>
</html>
