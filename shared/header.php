<?php

session_start();

$current_user = $_SESSION['current_user'];

?>
<header>
  <a href="../home.php?user=<?php echo $current_user ?>" style="color: #333333">
    <div class="row">
      <div class="col-md-12 col-offset-3 text-center">
        <h1><b>PHOTOLIO</b></h1>
        <h4><b>A site for photo sharing</b></h4>
      </div>
    </div>
  </a>
</header>
