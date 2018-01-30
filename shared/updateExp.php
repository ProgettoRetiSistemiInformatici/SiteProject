<?php
require '../initialization/dbconnection.php';

$istr = $_SESSION['istr'];

if($istr){
  $mysqli->query("UPDATE login SET exp = exp + 100 WHERE id = '$followed_id';");
  $current_user = $followed_id;

}
else{
  $mysqli->query("UPDATE login SET exp = exp + 50 WHERE id = '$current_user';");

}
require '../profiles/growlevel.php';

unset($_SESSION['istr']);

?>
