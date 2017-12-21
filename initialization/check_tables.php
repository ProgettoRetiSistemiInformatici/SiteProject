<?php

  require 'dbconnection.php';

  if ($result = $mysqli->query("SHOW TABLES LIKE 'login'")) {
    if(!$result->num_rows == 1) {
      // sql to create table
      $sql = "CREATE TABLE login(
        id INT(5) NOT NULL AUTO_INCREMENT,
        email VARCHAR(64) NOT NULL UNIQUE,
        password VARCHAR(64) NOT NULL,
        firstname VARCHAR(64) DEFAULT NULL,
        lastname VARCHAR(64) DEFAULT NULL,
        gender ENUM('male', 'female') DEFAULT NULL,
        birth DATE DEFAULT NULL,
        descuser TEXT,
        level INT(11) DEFAULT 1,
        profile_image VARCHAR(64) DEFAULT 'Default.png',
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
        user_id int(5) NOT NULL,
        rate INT(5) NOT NULL DEFAULT 0,
        votes INT(5) NOT NULL DEFAULT 0,
        description VARCHAR(160),
        tags TEXT,
        PRIMARY KEY (id),
        FOREIGN KEY(user_id) REFERENCES login(id));";

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
        user_id INT(5) NOT NULL,
        photo_id INT(5) NOT NULL,
        comment VARCHAR(200) NOT NULL,
        PRIMARY KEY(id),
        FOREIGN KEY(user_id) REFERENCES login(id),
        FOREIGN KEY(photo_id) REFERENCES photo(id));";

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
        photos_id TEXT NOT NULL,
        PRIMARY KEY (id));";

      if ($mysqli->query($sql) === TRUE) {
      } else {
        echo "Error creating table: " . $mysqli->error;
      }
    }
  }

  if ($result = $mysqli->query("SHOW TABLES LIKE 'relations'")) {
    if(!$result->num_rows == 1) {
      //sql create table
      $sql = "CREATE TABLE relations(
        id INT(5) NOT NULL AUTO_INCREMENT,
        follower_id INT(5) NOT NULL,
        followed_id INT(5) NOT NULL,
        PRIMARY KEY(id),
        UNIQUE(follower_id, followed_id),
        FOREIGN KEY (follower_id) REFERENCES login(id),
        FOREIGN KEY (followed_id) REFERENCES login(id));";

      if ($mysqli->query($sql) === TRUE) {
      } else {
        echo "Error creating table: " . $mysqli->error;
      }
    }
  }

  if ($result = $mysqli->query("SHOW TABLES LIKE 'albums'")) {
    if(!$result->num_rows == 1) {
      // sql to create table
      $sql = "CREATE TABLE albums(
        id INT(5) NOT NULL AUTO_INCREMENT,
        title VARCHAR(16) NOT NULL,
        user_id INT(5) NOT NULL,
        photos_id TEXT NOT NULL,
        cover VARCHAR(64) DEFAULT NULL,
        PRIMARY KEY(id),
        FOREIGN KEY (user_id) REFERENCES login(id));";

      if ($mysqli->query($sql) === TRUE) {
      } else {
        echo "Error creating table: " . $mysqli->error;
      }
    }
  }

 ?>
