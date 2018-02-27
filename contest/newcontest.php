<?php
session_start();

$current_user = $_SESSION['current_user'];
?>
<html>
<head><?php include '../shared/meta.php'; ?></head>
<body>
    <div class='container'>
        <?php include '../shared/header.php'; ?>
        <?php include '../shared/menuProfile.php'; ?>
    <form action ="create_contest.php" method="post" enctype="multipart/form-data">
        <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-6">
              <div class="panel panel-default">
                 <div class="panel-body">
                  <div class="form-group text-center">
                    <label for="InputFile">Choose contest's image:</label>
                    <input class="center-block" type="file" id="InputFile" name="contestImage">
                    <p class="help-block">This image will be the front image of the contest's page you will create.</p>
                  </div>
                </div>
              </div>
            </div>
              <div class="col-md-6">
              <div class="row"> 
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <div class="form-group">
                        <label for="InputName">Contest's Name:</label>
                        <input name="name" type="text" class="form-control" id="InputName" placeholder="Contest's Name">
                        <p class="help-block">Choose the contest name, it will show to other users that want to compete.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class='row'>
                  <div class='col-md-12'>
                      <div class='panel panel-default'>
                          <div class='panel panel-body'>
                              <div class='form-group'>
                                  <label for='InputDate'>End Date:</label>
                                  <input name ='enddate' type='date' class='form-control' id='InputDate' placeholder='Enter a date'>
                                  <p class='help-block'><b>PLEASE NOTE:</b> for the contest to be valid you can't choose a date prior to</p>
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
                        <label for="InputDesc">Contest's Description:</label>
                        <textarea name="description" maxlength="300" class="form-control" id="inputDesc" rows="4"></textarea>
                        <p class="help-block">Insert a description in this text box: the more is clear the subject, the more competitive will be the contest</p>
                      </div>
                    </div>
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
         </div>
        </div>
        </div>
    </form>
    </div>
     <?php include '../shared/footer.php'; ?>
</body>
</html>