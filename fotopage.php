<?php
include ('dbconnection.php');
session_start();

$foto = $_GET['foto'];
$foto = filter_var($foto,FILTER_SANITIZE_STRING);

global $mysqli;
$query ="SELECT rating from photo where nome = '$foto'";
if(!$result = $mysqli->query($query)){
    die($mysqli->error);
}

?>

<!DOCTYPE html>
<html>
        <head>
            <title> Rate this Photo!</title>
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
                
                sel {
                    position: bottom;
                    float:left;
                    background-color: #00ff00;
                    padding-left: 10px;
                }
                
            </style>
        </head>
        <body>
            
            <!-- Menu -->
        <ul>
            <li><a href="<?php echo "/home.php?user=" .$_SESSION["utente"] ?>" >Home</a></li>
            <li><a href="uploadFile.html">Load Image</a></li>
            <li><a href="#contact">Share Us</a></li>
            <li><a href="logOut.php">Log Out</a></li>
        </ul>
            
            <!--Immagine -->
            <img src="<?php echo "uploads/". $foto ?>" style="width:60%" alt ="<?php echo $foto;?>" height="300" width="200"  ><br>
        <sel>
            <form action="submitrate.php" method="post">
            1<input type="radio" name="rating" value="1"/><br>
            2<input type="radio" name="rating" value="2"/><br>
            3<input type="radio" name="rating" value="3"/><br>
            4<input type="radio" name="rating" value="4"/><br>
            5<input type="radio" name="rating" value="5"/><br>
            <input type="submit" value ="Rate!"/>
            </form>
        </sel>        
        </body>        
</html>
<?php
$_SESSION['voto'] = $_POST['rating'];
session_write_close();
?>
