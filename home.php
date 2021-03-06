<?php
//le foto andranno caricate da database tramite php
require 'initialization/dbconnection.php';

if(isset($_SESSION['current_user'])){
  $user = $_SESSION['current_user'];
  $guest = false;
}
else{
  $user = -1;
  $guest = true;
}

$followers = "SELECT followed_id FROM relations WHERE follower_id = '$user';";
if(!$followers = $mysqli->query($followers)){
  echo $mysqli->error;
}
else{
  $follower_ids = array();
  for($i = 0; $follower = $followers->fetch_object(); $i++){
    $follower_ids[$i] = $follower->followed_id;
  }
  $follower_ids = join("','", $follower_ids);
}

$query = "SELECT id, name, title FROM photo ORDER BY id DESC LIMIT 8;";
$query .= "SELECT * FROM login ORDER BY id DESC LIMIT 5;";
$query .= "SELECT sharing.id, sharing.by_user_id, photo.id, photo.name, photo.title, login.firstname FROM photo INNER JOIN sharing ON photo.id = sharing.photo_id AND sharing.by_user_id IN ('$follower_ids') INNER JOIN login ON sharing.by_user_id = login.id ORDER BY sharing.id DESC LIMIT 6;";


if ($mysqli->multi_query($query)){
    $photos = $mysqli->store_result();
    if($mysqli-> next_result()){
        $profiles = $mysqli->store_result();
    }
    if($mysqli->next_result()){
      $shares = $mysqli->store_result();
    }
}
else{
  die($mysqli->error);
}

$mysqli->close();
session_write_close();

?>

<!DOCTYPE html>
<html lang='en'>
<head>
<?php include 'shared/meta.php'; ?>
<style>#iubenda-cs-banner{top:0!important;left:0!important;position:fixed!important;width:100%!important;z-index:99999998!important;background:#000;background:rgba(0,0,0,.85)}.iubenda-cs-content{display:block;margin:0 auto;padding:10px 50px 10px 20px;width:auto;font-family:Helvetica,Arial,FreeSans,sans-serif;font-size:12px;color:#fff!important}.iubenda-cs-rationale{max-width:900px;position:relative;margin:0 auto}.iubenda-banner-content>p{font-family:Helvetica,Arial,FreeSans,sans-serif;line-height:1.5}.iubenda-cs-close-btn{color:#fff!important;text-decoration:none;font-size:12px;position:absolute;top:-5px;right:-20px;border:1px solid #fff!important;display:inline-block;width:20px;height:20px;line-height:20px;text-align:center;border-radius:10px}.iubenda-cs-cookie-policy-lnk{text-decoration:underline;color:#fff!important;font-size:12px;font-weight:900}</style>
<script type="text/javascript">/*<![CDATA[*/
  var _iub = _iub || [];
  _iub.csConfiguration = {
    siteId: 1025613, cookiePolicyId: 25819051, lang: 'it', localConsentDomain: 'photolio.altervista.org',
    banner: { applyStyles: false, content: "Questo sito utilizza cookie di terze parti per inviarti pubblicit&agrave; in linea con le tue preferenze. Se vuoi saperne di pi&ugrave; o negare il consenso a tutti o ad alcuni cookie, %{cookie_policy_link}. Chiudendo questo banner, scorrendo questa pagina, cliccando su un link o proseguendo la navigazione in altra maniera, acconsenti all&apos;uso dei cookie.", cookiePolicyLinkCaption: "clicca qui"}
  };
  (function (w, d) {
    var loader = function () { var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0]; s.src = "//cdn.iubenda.com/cookie_solution/iubenda_cs.js"; tag.parentNode.insertBefore(s, tag); };
    if (w.addEventListener) { w.addEventListener("load", loader, false); } else if (w.attachEvent) { w.attachEvent("onload", loader); } else { w.onload = loader; }
  })(window, document);
  /*]]>*/</script>
</head>
<body>
<div class="container">
<!-- Header -->
<?php include 'shared/header.php' ?>
<!-- Menu -->
<?php include 'shared/menuProfile.php'; ?>
<!-- Photo Grid -->
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Lastest updates</h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <?php if($shares->num_rows):
            while($obj = $shares->fetch_object()): ?>
              <div class="col-sm-4">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <a href="../profiles/profile.php?user=<?php echo $obj->by_user_id ?>"><h3 class="panel-title">Shared by: <?php echo $obj->firstname; ?></h3></a>
                  </div>
                  <div class="panel-body">
                    <a href="../gallery/photo_page.php?photo_id=<?php echo $obj->id; ?>">
                      <img style="height:200px" class="center-block img-responsive img-rounded" src="<?php echo "/uploads/".$obj->name ?>" alt="Immagine">
                    </a>
                  </div>
                  <table class="table">
                    <ul class="list-group">
                      <li class="list-group-item text-center"><h4><?php echo $obj->title ?></h4></li>
                      <li class="list-group-item text-center">
                        <a href="https://plus.google.com/share?url=http%3A%2F%2Fphotolio.com%2Fgallery%2Fphoto_page.php%3Fphoto_id%3D<?php echo $obj->id; ?>"
                          class="btn btn-danger" aria-hidden="true"
                          target="_blank">G+</a>
                        <a href="https://facebook.com/sharer/sharer.php?u=http%3A%2F%2Fphotolio.com%2Fgallery%2Fphoto_page.php%3Fphoto_id%3D<?php echo $obj->id; ?>&amp"
                          class="btn btn-primary" aria-hidden="true"
                          target="_blank">Facebook</a>
                      </li>
                    </ul>
                  </table>
                </div>
              </div>
          <?php endwhile;
        else: ?>
          <div class="col-sm-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <h4 class = 'text-center'>No updates to show</h4>
                <h4 class="text-center">Start following someone to see what he share!</h4>
              </div>
            </div>
          </div>
        <?php  endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Lastest photos</h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <?php while($obj = $photos->fetch_object()): ?>
                <div class="col-md-6">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <a href="../gallery/photo_page.php?photo_id=<?php echo $obj->id?>">
                        <img style="height:200px" class="center-block img-responsive img-rounded" src="<?php echo "/uploads/".$obj->name ?>" alt="Immagine">
                      </a>
                    </div>
                    <table class="table">
                      <ul class="list-group">
                        <li class="list-group-item text-center"><h4><?php echo $obj->title ?></h4></li>
                        <li class="list-group-item text-center">
                          <a href="https://plus.google.com/share?url=http%3A%2F%2Fphotolio.com%2Fgallery%2Fphoto_page.php%3Fphoto_id%3D<?php echo $obj->id; ?>"
                            class="btn btn-danger" aria-hidden="true"
                            target="_blank">G+</a>
                          <a href="https://facebook.com/sharer/sharer.php?u=http%3A%2F%2Fphotolio.com%2Fgallery%2Fphoto_page.php%3Fphoto_id%3D<?php echo $obj->id; ?>&amp"
                            class="btn btn-primary" aria-hidden="true"
                            target="_blank">Facebook</a>
                        </li>
                      </ul>
                    </table>
                  </div>
                </div>
            <?php endwhile; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Newest Users</h3>
        </div>
        <div class="panel-body">
          <?php while($profile = $profiles->fetch_object()): ?>
              <div class="panel panel-default">
                <div class="panel-body">
                  <div class="col-md-6">
                    <img class="img-responsive img-rounded" src="<?php echo "../profiles/profile_images/". $profile->profile_image;?>"></h3>
                  </div>
                  <div class = "row" >
                  	<div class="col-md-12" style="margin-top: 10px">
                     <table class="table">
                      <ul class="list-group">
                      	<?php
                            if (!empty($profile->firstname) || !empty($profile->lastname)){
                              echo "<li class='list-group-item'><b>Name:</b> " . $profile->firstname . " " . $profile->lastname . "</li>";
                            }
                            if(!empty($profile->birth)){
                              $date = date('d-m-Y',strtotime($profile->birth));
                              echo "<li class='list-group-item'><b>Birth Date:</b> " . $date ."</li>";
                            }
                            echo "<li class='list-group-item'><b>Level:</b> " . $profile->level . "</li>";

                            if (!empty($profile->descuser)){
                              echo "<li class='list-group-item'><b>About Me:</b> " . $profile->descuser . "</li>";
                            }
                      	?>
                      </ul>
                     </table>
                    </div>
                  </div>
                  <a href="../profiles/profile.php?user=<?php echo $profile->id ?>" class="btn btn-default pull-right">Show profile</a>
                </div>
              </div>
            <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>
  <?php include 'shared/footer.php'; ?>
</body>
</html>
