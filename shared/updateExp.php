<?php
require '../initialization/dbconnection.php';

$istr = $_SESSION['istr'];

if($istr){
  $mysqli->query("UPDATE login SET exp = exp + 100 WHERE id = '$followed_id';");
  $user = $followed_id;

}
else{
  $mysqli->query("UPDATE login SET exp = exp + 50 WHERE id = '$current_user';");
  $user = $current_user;
}
require '../profiles/grownlevel.php';

unset($_SESSION['istr']);

?>
