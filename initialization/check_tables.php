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
        photos_id INT(99) NOT NULL,
        PRIMARY KEY (id));";

      if ($mysqli->query($sql) === TRUE) {
      } else {
        echo "Error creating table: " . $mysqli->error;
      }
    }
  }

  if ($result = $mysqli->query("SHOW TABLES LIKE 'users'")) {
    if(!$result->num_rows == 1) {
      // sql to create table
      $sql = "CREATE TABLE users(
        id INT(5) NOT NULL AUTO_INCREMENT,
        name VARCHAR(16) NOT NULL,
        firstname VARCHAR(64) DEFAULT NULL,
        lastname VARCHAR(64) DEFAULT NULL,
        gender ENUM('male', 'female') DEFAULT NULL,
        email VARCHAR(64) NOT NULL,
        birth DATE DEFAULT NULL,
        descuser TEXT,
        level INT(11) DEFAULT 1,
        profile_image VARCHAR(64) DEFAULT 'Default.png',
        PRIMARY KEY (id),
        FOREIGN KEY(email) REFERENCES login(email),
        FOREIGN KEY(name) REFERENCES login(user));";

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
        idUser1 INT(11) NOT NULL,
        idUser2 INT(11) NOT NULL,
        PRIMARY KEY(id),
        UNIQUE(idUser1, idUser2),
        FOREIGN KEY (idUser1) REFERENCES users(id),
        FOREIGN KEY (idUser2) REFERENCES users(id));";

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
        user VARCHAR(16) NOT NULL,
        idPhoto TEXT NOT NULL,
        cover VARCHAR(64) DEFAULT NULL,
        PRIMARY KEY(id),
        FOREIGN KEY (user) REFERENCES users(name));";

      if ($mysqli->query($sql) === TRUE) {
      } else {
        echo "Error creating table: " . $mysqli->error;
      }
    }
  }

 ?>
