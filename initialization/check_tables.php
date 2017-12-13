<?php

  require 'dbconnection.php';

  if ($result = $mysqli->query("SHOW TABLES LIKE 'login'")) {
    if(!$result->num_rows == 1) {
      // sql to create table
      $sql = "CREATE TABLE login(
        id INT(5) NOT NULL AUTO_INCREMENT,
        user VARCHAR(16) NOT NULL UNIQUE,
        password VARCHAR(64) NOT NULL,
        email VARCHAR(64) NOT NULL UNIQUE,
        PRIMARY KEY(id));";

      if ($mysqli->query($sql) === TRUE) {
      } else {
        echo "Error creating table: " . $mysqli->error;
      }
    }
  }

  if ($result = $mysqli->query("SHOW TABLES LIKE 'photo'")) {
    if(!$result->num_rows == 1) {
      //sql create table
      $sql = "CREATE TABLE photo(
        id INT(5) NOT NULL AUTO_INCREMENT,
        name VARCHAR(64) NOT NULL UNIQUE,
        user VARCHAR(64) NOT NULL,
        rate INT(5) NOT NULL DEFAULT 0,
        votes INT(5) NOT NULL DEFAULT 0,
        description VARCHAR(160),
        tag TEXT,
        PRIMARY KEY (id),
        FOREIGN KEY(user) REFERENCES login(user));";

      if ($mysqli->query($sql) === TRUE) {
      } else {
        echo "Error creating table: " . $mysqli->error;
      }
    }
  }

  if ($result = $mysqli->query("SHOW TABLES LIKE 'comments'")) {
    if(!$result->num_rows == 1) {
      //sql create table
      $sql = "CREATE TABLE comments(
        id INT(5) NOT NULL AUTO_INCREMENT,
        user VARCHAR(16) NOT NULL,
        photo VARCHAR(64) NOT NULL,
        comment VARCHAR(200) NOT NULL,
        PRIMARY KEY(id),
        FOREIGN KEY(user) REFERENCES login(user),
        FOREIGN KEY(photo) REFERENCES photo(name));";

      if ($mysqli->query($sql) === TRUE) {
      } else {
        echo "Error creating table: " . $mysqli->error;
      }
    }
  }

  if ($result = $mysqli->query("SHOW TABLES LIKE 'tags'")) {
    if(!$result->num_rows == 1) {
      //sql create table
      $sql = "CREATE TABLE tags(
        id INT(5) NOT NULL AUTO_INCREMENT,
        tag VARCHAR(16) NOT NULL UNIQUE,
        photo TEXT NOT NULL,
        PRIMARY KEY (id));";

      if ($mysqli->query($sql) === TRUE) {
      } else {
        echo "Error creating table: " . $mysqli->error;
      }
    }
  }

 ?>
