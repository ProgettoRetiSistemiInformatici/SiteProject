<?php
    require '../initialization/dbconnection.php';

    $guest = false;

    if(empty($_SESSION['current_user'])){
      $guest = true;
    }

    $photo_id = $_GET['photo_id'];

    global $mysqli;
    $query = "SELECT name, user_id, title, description, (rate/votes) AS finalrate FROM photo WHERE id ='$photo_id';";
    if(!$result = $mysqli->query($query)){
        die($mysqli->error);
    }
    else{
        $obj = $result->fetch_object();
        $photo_name = $obj->name;
        $photographer_id = $obj->user_id;
        $title = $obj->title;
        $desc = $obj->description;
        $rate = $obj->finalrate;
        if($rate == NULL){
            $rate = 0;
        }
    }

    $query = "SELECT firstname FROM login WHERE id = '$photographer_id';";
    $query .= "SELECT comments.comment, login.id, login.email, login.firstname FROM login INNER JOIN comments ON comments.user_id = login.id AND comments.photo_id = '$photo_id';";
    if ($mysqli->multi_query($query)){
      if($result = $mysqli->store_result()){
          $photographer = $result->fetch_object();
          $fuser = $photographer->firstname;
      }
      if($mysqli->next_result()){
        $comments = $mysqli->store_result();
      }
    }
    session_write_close();
    $mysqli->close();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include '../shared/meta.php'; ?>
    </head>
    <body>
      <div class="container">
        <?php include '../shared/header.php'; ?>
      <!-- Menu -->
        <?php include '../shared/menuProfile.php'; ?>
      <!-- Photo Div -->
      <form action="save_comment.php?photo_id=<?php echo $photo_id; ?>" method="post">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <img class="center-block img-responsive img-rounded" src="<?php echo "/uploads/" .$photo_name; ?>" alt="Immagine" class='img-responsive center-block'>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12 text-center">
                    <div class="panel panel-default">
                      <div class="panel-body">
                        <div class="col-md-12 text-center">
                          <h3><b>Photographer:</b> <a href="../profiles/profile.php?user=<?php echo $photographer_id; ?>"><?php echo $fuser; ?></a></h3>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="panel panel-default">
                      <table class="table">
                        <ul class="list-group">
                          <li class="list-group-item text-center"><p><b>Title:</b> <?php echo $title; ?></p></li>
                          <li class="list-group-item text-center"><p><b>Rating:</b> <?php echo round($rate, 2); ?>/5</p></li>
                          <li class="list-group-item text-center">
                            <a href="https://plus.google.com/share?url=http%3A%2F%2Flocalhost%3A8000%2Fgallery%2Fphoto_page.php%3Fphoto_id%3D<?php echo $photo_id; ?>&amp"
                              class="btn btn-danger" aria-hidden="true"
                              target="_blank">G+</a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Flocalhost%3A8000%2Fgallery%2Fphoto_page.php%3Fphoto_id%3D<?php echo $photo_id; ?>&amp"
                              class="btn btn-primary" aria-hidden="true"
                              target="_blank">Facebook</a>
                            <?php if(!$guest): ?>
                              <button id="share" type="button" data-toggle="modal" data-target="#share-photo" class="btn btn-default">Share</button>
                            <?php endif; ?>
                          </li>
                        </ul>
                      </table>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="panel panel-default">
                      <table class="table">
                        <ul class="list-group">
                          <?php if(!empty($desc)): ?>
                            <li class="list-group-item text-center"><p><b>Description:</b> <?php echo $desc; ?></p></li>
                          <?php else: ?>
                            <li class="list-group-item text-center"><p><b>Description:</b> No description provided.</p></li>
                          <?php endif; ?>
                        </ul>
                      </table>
                    </div>
                  </div>
                </div>
                <?php
                if(!$guest): ?>
                  <div class="col-md-12 text-center">
                    <div class="form-group">
                      <p><b>Rate:</b></p>
                      <label class="radio-inline">
                        <input type="radio" name="rate" id="inlineRadio1" value="1"> 1
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="rate" id="inlineRadio2" value="2"> 2
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="rate" id="inlineRadio3" value="3"> 3
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="rate" id="inlineRadio4" value="4"> 4
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="rate" id="inlineRadio5" value="5"> 5
                      </label>
                    </div>
                  </div>
              <?php endif ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading text-center">
                <h3>Comments</h3>
              </div>
              <div class="panel-body">
                <div class="col-md-6">
                  <table class="table">
                    <ul class="list-group">
                      <?php
                        if($comments->num_rows){
                          while($obj = $comments->fetch_object()){
                            echo '<li class="list-group-item">';
                            echo "<p><b><a href='../profiles/profile.php?user=" . $obj->id . "'>" . $obj->firstname . "</a></b>: " . $obj->comment . "</p></li>";
                          }
                        }
                        else {
                          echo '<li class="list-group-item">';
                          echo "<p>No comments yet. Be the first one to comment!!</p></li>";
                        }?>
                    </ul>
                  </table>
                </div>
                <?php
                  if(!$guest): ?>
                    <div class="col-md-6 text-center">
                      <div class="form-group">
                        <textarea name="comment" id="insertComment" rows="3" class="form-control" placeholder="Comment..."></textarea>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 text-center">
                        <button class="btn btn-primary" type="submit">Send</button>
                      </div>
                    </div>
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="share-photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            Photo shared with your follower!
          </div>
        </div>
      </div>
    </div>
      <?php include '../shared/footer.php'; ?>
  <script>
    $('#share').click(function() {
      var photo_id = <?php echo $photo_id ?>;
      $.ajax({
        type: 'POST',
        url: 'sharing.php',
        data: { photo_id: photo_id },
        success: function(response) {
          content.html(response);
        }
      });
    });
  </script>
</body>
</html>
