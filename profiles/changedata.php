<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head><?php include '../shared/meta.php'; ?></head>
<body>
  <div class="container">
    <?php include '../shared/header.php'; ?>
    <?php include '../shared/menuProfile.php'; ?>
    <form action="savechanges.php" method="post" enctype="multipart/form-data">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-6">
              <div class="panel panel-default">
                <div class="panel-body">
                  <p><b>Actual profile image:</b></p>
                  <img alt="Profile image" class="img-rounded img-responsive" src="<?php echo "profile_images/". $_SESSION['profile']->profile_image;?>">
                </div>
                <div class="panel-body">
                  <div class="form-group text-center">
                    <label for="InputFile">Choose new profile image:</label>
                    <input class="center-block" type="file" id="InputFile" name="newPimage">
                    <p class="help-block">Modify your current profile image</p>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-body text-center">
                  <button class="btn btn-primary" type="submit">Submit</button>
                  <button class="btn btn-default" type="reset">Reset</button>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <div class="form-group">
                        <label for="InputEmail">Email:</label>
                        <input name="newEmail" type="email" class="form-control" id="InputEmail" placeholder="<?php echo  $_SESSION['profile']->email ?>">
                        <p class="help-block">Modify your current email</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <div class="form-group">
                        <label for="InputName">Firstname:</label>
                        <input name="newName" type="text" class="form-control" id="InputName" placeholder="<?php echo  $_SESSION['profile']->firstname ?>">
                        <p class="help-block">Modify your current name</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <div class="form-group">
                        <label for="InputLastname">Lastname:</label>
                        <input name="newLName" type="text" class="form-control" id="InputLastname" placeholder="<?php echo  $_SESSION['profile']->lastname ?>">
                        <p class="help-block">Modify your current lastname</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <label for="InputBirthDate">Birth Date:</label>
                      <input name="newBirth" type="date" class="form-control" id="InputLastname" placeholder="<?php echo  date('d-m-Y',strtotime($_SESSION['profile']->birth)) ?>">
                      <p class="help-block">Modify your current birth date</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <label for="inputUDesc">Description:</label>
                      <textarea name="aboutMe" maxlength="200" class="form-control" id="inputUDesc" rows="3"></textarea>
                      <p class="help-block">Insert a short description of yourself</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</body>
</html>
