<?php
require '../initialization/dbconnection.php';
if(isset($_GET['group'])){
    $idgroup= $_GET['group'];
}
else{
    $idgroup = $_SESSION['group_id'];
}
$_SESSION['group_id'] = $_GET['group'];
$current_user = $_SESSION['current_user'];
$queryinfo ="SELECT login.firstname, groups.id as id, groups.name, groups.group_cover, groups.admin, groups.description"
        . " as descuser from (groups join login on admin = login.id) where groups.id ='$idgroup';";
$querymembers = "SELECT login.id, login.firstname, login.profile_image, login.email FROM (login join membership on login.id = membership.member_id) "
        . "where membership.group_id='$idgroup';";
$flistquery = "SELECT follower_id, login.firstname, login.profile_image FROM (relations join login on login.id = follower_id) WHERE followed_id = '$current_user'";
$usernamequery ="SELECT login.firstname,login.id from (login join membership on member_id = login.id) where login.id = '$current_user';";
if(!$info= $mysqli->query($queryinfo)){
    die($mysqli->error);
}
$infos = $info->fetch_object();
if(!$membership=$mysqli->query($querymembers)){
    die($mysqli->error);
}
if(!$flist = $mysqli->query($flistquery)){
    die($mysqli->error);
}
if(!$username =$mysqli->query($usernamequery)){
    die($mysqli->error);
}
$user = $username ->fetch_assoc();
$name = $user["firstname"];
$iduser = $user["id"];
?>
<html>
    <head>
       <?php include '../shared/meta.php'; ?>
        <style>
            .chat {
    max-width: 600px;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
}

.chat #chatOutput {
    overflow-y: scroll;
    height: 280px;
    width: 100%;
    border: 2px solid #777;
}

.chat #chatOutput p{
    margin:0;
    padding:5px;
    border-bottom: 1px solid #bbb;
    word-break: break-all;
}

.chat #chatInput {
    width: 75%;
}

.chat #chatSend {
    width: 25%;
}
        </style>
    </head>
    <body>
        <div class="container">
        <!-- Header -->
        <?php include '../shared/header.php'; ?>
        <!-- Menu -->
        <?php include '../shared/menuProfile.php'; ?>
        <!--Group's Info -->
        <div class="row">
            <div class="col-md-3">
                <div class='panel panel-default'>
                    <div class='panel-heading'>
                        <h3 class='panel-title'>
                            <p><b>Group's Info</b></p>
                            <?php if(!empty($infos->group_cover)) {
                                echo '<img class="img-responsive img-rounded" src="group_covers/' . $infos->group_cover . '"></h3>';
                            } else{ echo '<img class="img-responsive img-rounded" src="group_covers/Default.png"></h3>'; } ?>
                    </div>                   
                    <div class='panel-body'>
                        <ul class='list-group'>
                            <li class='list-group-item'><b>Name:</b> <?php echo $infos->name; ?></li>
                            <li class='list-group-item'><b>Description: </b> <?php echo $infos->descuser; ?></li>
                            <li class='list-group-item'><b>Admin: </b><?php echo $infos->firstname; ?></li>
                            <?php if($current_user == $infos->admin){ ?>
                            <li class='list-group-item'><a href='delete_group.php?group=<?php echo $idgroup ?>'><button>Delete Group!</button></a></li>
                            <li class="list-group-item"><button id="InviteButton" data-toggle="modal" data-target="#invite-people">Invite People</button></li>
                            <?php } ?>
                            <?php if($iduser != $infos->admin){ ?>
                            <li class='list-group-item'><a href='leave_group.php?group=<?php echo $idgroup ?>'><button>Leave Group!</button></a></li>
                            <li class="list-group-item"><button id="InviteButton" data-toggle="modal" data-target="#invite-people">Invite People</button></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        <!-- Chat Box -->
        <div class='col-md-6'>
            <header class='header'>
                <h2>Group's Chat</h2>
            </header>
            <main>
                <div class="chat">
                    <div id="chatOutput"></div>
                    <input id="chatInput" type="text" placeholder="Input Text here" maxlength="128">
                    <button id="chatSend" onclick="SendMessage()">Send</button>
                </div>
            </main>
        </div>
        <!-- Members Box -->
        <div class='col-md-3'>
            <div class='panel panel-default'>
                <div class='panel-heading'>
                    <h3 class='panel-title'>Group Members</h3>
                </div>
                <div class='panel-body'>
                    <?php while ($members = $membership->fetch_object()): ?>
                    <ul class='list-group'>
                        <li class='list-group-item'><img src='../profiles/profile_images/<?php echo $members->profile_image; ?>' alt ='Immagine' class='img-responsive img-rounded'></li>
                        <li class='list-group-item'>Name: <?php echo $members->firstname; ?></li>
                    </ul>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
        </div>
        <?php include '../shared/footer.php'; ?>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="invite-people" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                   <ul class="list-group">
                 <?php if($flist->num_rows): ?>
                    <?php while($toinvite = $flist->fetch_object()): ?>
                       <li style="width:30%"class='list-group-item'><img src='../profiles/profile_images/<?php echo $toinvite->profile_image; ?>' alt ='Immagine' class='img-responsive img-rounded'></li>
                       <li class="list-group-item"><?php echo $toinvite->firstname;?></li>
                       <li class="list-group-item"><a href="invite_group.php?user=<?php echo $toinvite->follower_id;?>"><button>Invite!</button></a></li>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <li class="list-group-item text-center"><p> Sorry, You can't invite Users if they're not your followers.</p></li>
                    <?php endif; ?> 
                   </ul>
                </div>
              </div>
            </div>
        </div>
        <script>            
            function SendMessage() {
                var chat_group = <?php echo $idgroup;?>;
                var userName = '<?php echo $name;?>';
                var xhttp = new XMLHttpRequest();
                var text = $("#chatInput").val();
                xhttp.open("GET", "./write.php?group_id="+chat_group+"&username="+userName+"&text="+text, true);
                xhttp.send();
            }
            
            $(document).ready(function() {
                var group_id = <?php echo $idgroup;?>;
                var $chatOutput = $("#chatOutput");
                setInterval(function () {
                    RetrieveMessages();
                }, 250);
                function RetrieveMessages() {
                    $.get("./read.php?group_id="+group_id, function (data) {
                        $chatOutput.html(data); //Paste content into chat output
                    });
                }
             
            })
        </script>
    </body>
</html>
