<?php

session_start();

//se non si e' loggati si viene reindirizzati nella pagina di registrazione/login
if(empty($_SESSION['current_user'])){
    var_dump("EH!");
    header("Location: /index.php");
}

?>
<!DOCTYPE html>
<html>
<head>
    <?php include '../shared/meta.php'; ?>
</head>
<body>
  <div class="container">
    <?php include '../shared/header.php'; ?>
    <!-- Menu -->
    <?php include '../shared/menuProfile.php'; ?>
    <div class="panel panel-default">
      <div class="panel-body">
        <form action="upload.php" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="form-group">
                <label for="inputFile">Select an image:</label>
                <input class="center-block" type="file" id="inputFile" name="fileToUpload">
                <p class="help-block" style="margin-top: 10px">Choose the image to upload</p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="inputDescription">Description:</label>
              <textarea name="description" class="form-control" id="inputDescription" rows="3" placeholder="Insert a title or a short description of the photo"></textarea>
            </div>
            <div class="col-md-6">
              <label for="inputTags">Tags:</label>
              <textarea name="tags" class="form-control" id="inputTags" rows="3" placeholder="Insert a series of word preceded by the # symbol"></textarea>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 text-center" style="margin-top: 10px">
              <button class="btn btn-primary" type="submit" name="submit">Submit</button>
              <button class="btn btn-default" type="reset">Reset</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
