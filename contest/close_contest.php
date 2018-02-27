<?php
require '../initialization/dbconnection.php';

$id = $_SESSION['contest_id'];

global $mysqli;
$queryMax = "SELECT MAX(votes) as max from (photo join photo_contest as pc on photo.id=pc.photo_id) WHERE pc.contest_id ='$id';";
if(!$votes = $mysqli->query($queryMax)){
    die($mysqli->error);
}
$vote = $votes->fetch_object();
$votemax = $vote->max;
$querychoosewinner = "SELECT p.id,p.user_id from (photo as p join photo_contest on p.id = photo_contest.photo_id) where p.votes = '$votemax';";
if(!$result = $mysqli->query($querychoosewinner)){
    die($mysqli->error);
} 

$chosen = $result->fetch_object();
$winner =  $chosen->user_id;
$photowin = $chosen->id;
$querywinnerelection = "UPDATE contest SET winner='$winner', winner_photo='$photowin', flag_close_open = 1 where id = '$id';";
$deletequery = "DELETE FROM photo_contest WHERE photo_id!='$photowin' && contest_id == '$id';";
$queryUpdateExp = "UPDATE login set exp = exp+500 where id = '$winner';";
$queryshare= "INSERT INTO share_winner (winner_id,contest_id) VALUES ('$winner','$id');";
if(!$mysqli->query($querywinnerelection)){
    die($mysqli->error);
} else {
    if(!$mysqli->query($deletequery)){
        die($mysqli->error);
    }
    if(!$mysqli->query($queryUpdateExp)){
        die($mysqli->error);
    }
    require '../profiles/growlevel.php';
    if(!$mysqli_>query($queryshare)){
        die($mysqli->error);
    }
}
$mysqli->close();
header('Location: contest_page.php');

?>