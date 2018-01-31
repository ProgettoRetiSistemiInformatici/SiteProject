<?php

if(empty($_SESSION['current_user'])){ ?>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="glyphicon glyphicon-camera navbar-brand" href="<?php echo "../home.php" ?>" aria-hidden="true"></a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <form form action="../shared/search.php" method="post" class="navbar-form navbar-left">
          <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Search">
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="../google-login/index.php">Login</a></li>
          <li><a href="../google-login/signup.php">Signup</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
<?php }
else{
  $current_user = $_SESSION['current_user']; ?>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="glyphicon glyphicon-camera navbar-brand" href="<?php echo "../home.php?user=" . $current_user ?>" aria-hidden="true"></a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li><a href="../load_image/uploadFile.php">Upload</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Albums <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo '../gallery/index_albums.php?user=' . $current_user ?>">Show Albums</a></li>
              <li><a href="<?php echo '../gallery/gallerychoose.php?user=' . $current_user ?>">Create Album</a></li>
            </ul>
          </li>

        </ul>
        <form form action="../shared/search.php" method="post" class="navbar-form navbar-left">
          <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Search">
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Profile <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href='../profiles/profile.php?user=<?php echo $current_user ?>'>Show profile</a></li>
              <li><a href="../profiles/changedata.php">Edit profile</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="../google-login/logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
<?php } ?>
