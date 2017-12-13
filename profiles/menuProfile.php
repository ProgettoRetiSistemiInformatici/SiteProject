<<<<<<< HEAD
<?php

session_start();

$user = $_SESSION['utente'];

?>
=======
<html>
<head>
>>>>>>> c4e8eed04fa369e772f4e2be70136ba753273096
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
</style>
<<<<<<< HEAD
  <ul>
    <li><a href=<?php echo'../home.php?user=' . $user ?>>Home</a></li>
    <li><a href='../load_image/uploadFile.html'>Load Image</a></li>
    <li><a href='#'>Share us on Google+</a></li>
    <li><a href='../google-login/logout.php'>Log Out</a></li>
    <li><a href='changedata.php'>Modifica Profilo</a></li>
    <li><a href=<?php echo '../gallery/gallerychoose.php?user=' . $user ?>>New Album</a></li>
    <?php if(isset($_GET['idS'])&&isset($_GET['id'])){
      echo ("<li><a href=profile.php?user=" . $_GET['user'] . ">Go Back</a></li><br>
        <li><a href=../gallery/deletealbum.php?id=" . $_GET['id'] . ">Delete this Album</a></li>";
      } ?>

</ul>
=======
</head>
<body>
  <ul>
    <li><a href="<?php echo "/home.php?user=" .$_SESSION["utente"] ?>" >Home</a></li>
    <li><a href="../uploadFile.html">Load Image</a></li>
    <li><a href="#">Share us on Google+</a></li>
    <li><a href="../google-login/logout.php">Log Out</a></li>
    <li><a href="changedata.php">Modifica Profilo</a></li>
  </ul>
</body>
</html>
>>>>>>> c4e8eed04fa369e772f4e2be70136ba753273096
