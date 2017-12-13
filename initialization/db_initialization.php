<?php
  session_start();
  require 'dbconnection.php';

  if(!$_SESSION['db_connection']){
    require 'create_db.php';
  }

  require 'check_tables.php';
  session_destroy();
  ?>
