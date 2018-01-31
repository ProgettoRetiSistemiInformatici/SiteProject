<?php

require '../initialization/dbconnection.php';

$albums = $_POST['albums'];
$ids = implode(", ", $albums);

$user = $_SESSION['current_user'];

$query="DELETE FROM albums WHERE id IN ('$ids') AND user_id = '$user';";
if(!$mysqli->query($query)){
    die($mysqli->error);
}
header("Location: ../gallery/index_albums.php?user=". $user);
exit();

?>
