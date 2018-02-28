<?php
require '../initialization/dbconnection.php';

if(isset($_GET['contest'])){
    $id = $_GET['contest'];
    $_SESSION['contest_id'] = $id;
}
else {
    $id = $_SESSION['contest_id'];
}
if(!$result = $mysqli->query("SELECT contest.name, contest.description, login.firstname, contest.winner, contest.flag_close_open, contest.creator, contest.contest_img, contest.endtime"
        . " FROM (contest join login on contest.creator = login.id) where contest.id = '$id';")){
    die($mysqli->error);
}
$obj = $result->fetch_object();


$queryp = "SELECT p.name,p.votes, p.title, p.id from (photo as p join photo_contest as c on p.id = c.photo_id) where c.contest_id = '$id'ORDER by p.votes;";
if(!$res2 = $mysqli->query($queryp)){
    die($mysqli->error);
}
if($obj->winner != null){
    $queryW="SELECT firstname FROM login where id='$obj->winner';";
    if(!$winres = $mysqli->query($queryW)){
        die($mysqli->error);
    }
    $win = $winres->fetch_object()->firstname;
}
$date_right = date('d-m-Y',strtotime($obj->endtime));
$today = new DateTime(date("d-m-Y"));
$expdate = new DateTime($date_right);

session_write_close();
?>
<html lang='en'>
<head>
    <?php include '../shared/meta.php'; ?>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <?php include '../shared/header.php'; ?>
        <!-- Menu -->
        <?php include '../shared/menuProfile.php'; ?>
    <!-- Contest's upper side (Cover, Info) -->
    <div class='row'>
        <div class='col-sm-12'>
            <div class='panel panel-default'>
                <div class='panel body'>
                    <img class='center-block img-responsive' src='contest_covers/<?php echo $obj->contest_img;?>' alt='Contest Cover'>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col md-6'>
            <div class='panel panel-default'>
                <table class='table'>
                    <ul class='list-group'>
                        <li class='list-group-item text-center'><p><b>Contest Name:</b> <?php echo $obj->name;?></p><br>
                            <p class="help-block"><?php echo $obj->description; ?></p></li>
                        <li class='list-group-item'><p><b>End Time:</b> <?php echo $date_right; ?></p></li>
                        <li class='list-group-item'><p><b>Contest Admin:</b><a href='../profiles/profile.php?user=<?php echo $obj->creator; ?>'> <?php echo $obj->firstname;?></a></p>
                        <?php if($obj->winner != null): ?>
                        <li class='list-group-item text-center'><p><b>Winner:</b> <a href='../profiles/profile.php?user=<?php echo $obj->winner;?>'>
                         <?php echo $win; endif; ?></a></p>
                        <?php if(($_SESSION['current_user']!= NULL)&&($_SESSION['current_user'] == $obj->creator) && ($today >= $expdate) && $obj->flag_close_open == 0): ?>
                        <li class='list-group-item'>
                            <a class="btn btn-default" href="close_contest.php">Close Contest</a>
                        <?php endif; ?>
                        <?php if($obj->flag_close_open != 0):?>
                        <li class="list-group-item"><p>Contest Already Closed!</p></li>
                        <?php endif; ?>
                        <?php if(($_SESSION['current_user'])!= NULL &&($_SESSION['current_user']!= $obj->creator) && ($today< $expdate)): ?>
                        <li class="list-group-item">
                            <a href="uploadforcontest.php" class="btn btn-default">Upload a Photo!</a>
                        </li>
                        <?php endif; ?> 
                    </ul>
                </table>
            </div>
        </div>
    </div>
    <!-- Contest down side (photo, casting votes ecc.) -->
        <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title text-center"><b>Contest Photos</b></h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <?php if($res2->num_rows != 0):
            while($photo = $res2->fetch_object()): ?>
              <div class="col-sm-4">
                <div class="panel panel-default">
                  <div class="panel-body">
                      <img style="height:200px" class="center-block img-responsive img-rounded" src="<?php echo "../uploads/".$photo->name ?>" alt="Immagine">
                  </div>
                  <table class="table">
                    <ul class="list-group">                        
                      <li class="list-group-item text-center"><h4><?php echo $photo->title; ?></h4></li>
                      <li class="list-group-item text-center">
                        <?php if($obj->winner == null):?>
                        <button id="CastVote" onclick="CastaVote(<?php echo $photo->id;?>)" type="button" class="btn btn-warning">Vote This Photo</button>
                         <?php endif; ?>
                        <a href="https://plus.google.com/share?url=http%3A%2F%2Fphotolio.com%2Fgallery%2Fphoto_page.php%3Fphoto_id%3D<?php echo $photo->id; ?>&amp"
                          class="btn btn-danger" aria-hidden="true"
                          target="_blank">G+</a>
                        <a href="https://facebook.com/sharer/sharer.php?u=http%3A%2F%2Fphotolio.com%2Fgallery%2Fphoto_page.php%3Fphoto_id%3D<?php echo $photo->id; ?>&amp"
                          class="btn btn-primary" aria-hidden="true"
                          target="_blank">Facebook</a>
                        <?php echo '<b> Votes: </b><p id="votes-'.$photo->id.'"></p> </li>
                    </ul>
                  </table>
                </div>
              </div>';?>
                    <script>
                        function CastaVote(id){
                            var xhttp = new XMLHttpRequest();
                            xhttp.open("GET","./castvote.php?photo="+id,true);
                            xhttp.send();    
                        }
                        
                        $(document).ready(function() {
                        var photo_id =<?php echo $photo->id;?>;
                        var $votes = $("#votes-"+photo_id);
                        setInterval(function () {
                            RetrieveMessages(photo_id);
                        }, 2000);
                        function RetrieveMessages(id) {
                            $.get("./readvote.php?photo="+id, function (data) {
                                $votes.html(data); //Paste content into chat output
                            });
                        }

                        })
                    </script>
          <?php endwhile;
    else: ?>
      <div class="col-sm-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <h4 class = 'text-center'>No photo to show</h4>
          </div>
        </div>
      </div>
    <?php  endif; ?>
    </div>
  </div>
</div>
</div>
<?php include '../shared/footer.php'; ?>
</body>
</html>