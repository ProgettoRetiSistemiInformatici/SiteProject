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
        exp INT(5) DEFAULT 0,
        profile_image VARCHAR(64) DEFAULT 'Default.png',
        PRIMARY KEY(id));";

      if ($mysqli->query($sql) === TRUE) {
      } else {
        echo "Error creating login: " . $mysqli->error;
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
        title VARCHAR(30) NOT NULL,
        description VARCHAR(160),
        PRIMARY KEY (id),
        FOREIGN KEY(user_id) REFERENCES login(id) ON DELETE CASCADE);";

      if ($mysqli->query($sql) === TRUE) {
      } else {
        echo "Error creating photo: " . $mysqli->error;
      }
    }
  }

  if ($result = $mysqli->query("SHOW TABLES LIKE 'tags'")) {
    if(!$result->num_rows == 1) {
      //sql create table
      $sql = "CREATE TABLE tags(
        id INT(5) NOT NULL AUTO_INCREMENT,
        tag VARCHAR(16) NOT NULL UNIQUE,
        PRIMARY KEY (id));";

      if ($mysqli->query($sql) === TRUE) {
      } else {
        echo "Error creating tags: " . $mysqli->error;
      }
    }
  }

  if ($result = $mysqli->query("SHOW TABLES LIKE 'tag_reference'")) {
    if(!$result->num_rows == 1) {
      //sql create table
      $sql = "CREATE TABLE tag_reference(
        id INT(5) NOT NULL AUTO_INCREMENT,
        tag_id INT(5) NOT NULL,
        photo_id INT (5) NOT NULL,
        user_id INT(5) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE,
        FOREIGN KEY (photo_id) REFERENCES photo(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES login(id) ON DELETE CASCADE);";

      if ($mysqli->query($sql) === TRUE) {
      } else {
        echo "Error creating tag_reference: " . $mysqli->error;
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
        FOREIGN KEY (follower_id) REFERENCES login(id) ON DELETE CASCADE,
        FOREIGN KEY (followed_id) REFERENCES login(id) ON DELETE CASCADE);";

      if ($mysqli->query($sql) === TRUE) {
      } else {
        echo "Error creating relations: " . $mysqli->error;
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
        cover VARCHAR(64) DEFAULT NULL,
        rate INT(5) NOT NULL DEFAULT 0,
        votes INT(5) NOT NULL DEFAULT 0,
        PRIMARY KEY(id),
        FOREIGN KEY (user_id) REFERENCES login(id) ON DELETE CASCADE);";

      if ($mysqli->query($sql) === TRUE) {
      } else {
        echo "Error creating albums: " . $mysqli->error;
      }
    }
  }


  if ($result = $mysqli->query("SHOW TABLES LIKE 'comments'")) {
    if(!$result->num_rows == 1) {
      //sql create table
      $sql = "CREATE TABLE comments(
        id INT(5) NOT NULL AUTO_INCREMENT,
        user_id INT(5) NOT NULL,
        photo_id INT(5) NULL,
        album_id INT(5) NULL,
        comment VARCHAR(200) NOT NULL,
        PRIMARY KEY(id),
        FOREIGN KEY(user_id) REFERENCES login(id),
        FOREIGN KEY(photo_id) REFERENCES photo(id) ON DELETE CASCADE,
        FOREIGN KEY(album_id) REFERENCES albums(id) ON DELETE CASCADE,
        CHECK(
          CASE WHEN album_id IS NULL THEN 0 ELSE 1 END +
          CASE WHEN photo_id IS NULL THEN 0 ELSE 1 END = 1
        ));";

      if ($mysqli->query($sql) === TRUE) {
      } else {
        echo "Error creating comments: " . $mysqli->error;
      }
    }
  }

  if ($result = $mysqli->query("SHOW TABLES LIKE 'contents'")) {
    if(!$result->num_rows == 1) {
      //sql create table
      $sql = "CREATE TABLE contents(
        id INT(5) NOT NULL AUTO_INCREMENT,
        album_id INT(5) NOT NULL,
        photo_id INT(5) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (album_id) REFERENCES albums(id) ON DELETE CASCADE,
        FOREIGN KEY (photo_id) REFERENCES photo(id) ON DELETE CASCADE);";

      if ($mysqli->query($sql) === TRUE) {
      } else {
        echo "Error creating contents: " . $mysqli->error;
      }
    }
  }


      if ($result = $mysqli->query("SHOW TABLES LIKE 'sharing'")) {
        if(!$result->num_rows == 1) {
          //sql create table
          $sql = "CREATE TABLE sharing(
            id INT(5) NOT NULL AUTO_INCREMENT,
            by_user_id INT(5) NOT NULL,
            photo_id INT(5) NOT NULL,
            PRIMARY KEY(id),
            UNIQUE(by_user_id, photo_id),
            FOREIGN KEY (by_user_id) REFERENCES login(id) ON DELETE CASCADE,
            FOREIGN KEY (photo_id) REFERENCES photo(id) ON DELETE CASCADE);";

          if ($mysqli->query($sql) === TRUE) {
          } else {
            echo "Error creating sharing: " . $mysqli->error;
          }
        }
      }


  if ($result = $mysqli->query("SHOW TABLES LIKE 'levels'")) {
    if(!$result->num_rows == 1) {
      // sql to create table
      $sql = "CREATE TABLE levels(
        id INT(2) NOT NULL AUTO_INCREMENT,
        level INT(11) NOT NULL,
        exp INT(5) NOT NULL,
        PRIMARY KEY(id));";

      if ($mysqli->query($sql) === TRUE) {
        $exp = 0;
        for ($i = 0; $i <  10; $i++){
          $exp = $exp + $i*1000;
          $query = "INSERT INTO levels (level, exp) VALUES ('$i', '$exp');";
          if(!$result = $mysqli->query($query)){
            echo "Error in fill level query";
          }
        }
      } else {
        echo "Error creating levels: " . $mysqli->error;
      }
    }
  }
    if($result = $mysqli->query("SHOW TABLES LIKE 'contest'")){
        if(!$result->num_rows == 1) {
            $sql = " CREATE TABLE `contest` (
                    `id` int(5) NOT NULL AUTO_INCREMENT,
                    `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `description` text COLLATE utf8mb4_unicode_ci,
                    `endtime` date NOT NULL,
                    `winner` int(5) DEFAULT NULL,
                    `winner_photo` int(5) DEFAULT NULL,
                    `contest_img` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT 'Default.png',
                    `creator` int(5) NOT NULL,
                    `flag_close_open` int(1) DEFAULT '0',
                    PRIMARY KEY (`id`),
                    KEY `winner` (`winner`),
                    KEY `winner_photo` (`winner_photo`),
                    KEY `creator` (`creator`),
                    CONSTRAINT `contest_ibfk_1` FOREIGN KEY (`winner`) REFERENCES `login` (`id`) ON DELETE CASCADE,
                    CONSTRAINT `contest_ibfk_2` FOREIGN KEY (`winner_photo`) REFERENCES `photo` (`id`) ON DELETE CASCADE,
                    CONSTRAINT `contest_ibfk_3` FOREIGN KEY (`creator`) REFERENCES `login` (`id`) ON DELETE CASCADE
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            if($mysqli->query($sql) === TRUE){
            } else {
                echo "Error creating contest:". $mysqli->error;
            }
        }
    }
    if($result = $mysqli->query("SHOW TABLES LIKE 'groups'")){
        if(!$result->num_rows == 1) {
            $sql = " CREATE TABLE `groups` (
                    `id` int(5) NOT NULL AUTO_INCREMENT,
                    `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `admin` int(5) NOT NULL,
                    `description` text COLLATE utf8mb4_unicode_ci,
                    `group_cover` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Default.png',
                    PRIMARY KEY (`id`),
                    KEY `groups_ibfk_1` (`admin`),
                    CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`admin`) REFERENCES `login` (`id`) ON DELETE CASCADE
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; ";
            if($mysqli->query($sql) === TRUE){
                
            }else{
                echo "Error creating groups:". $mysqli->error;
            }
        }
    }
    if($result = $mysqli->query("SHOW TABLES LIKE 'membership'")){
        if(!$result->num_rows == 1) {
            $sql = " CREATE TABLE `membership` (
                        `id` int(5) NOT NULL AUTO_INCREMENT,
                        `group_id` int(5) NOT NULL,
                        `member_id` int(5) NOT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `group_id` (`group_id`,`member_id`),
                        KEY `membership_ibfk_2` (`member_id`),
                        CONSTRAINT `membership_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
                        CONSTRAINT `membership_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `login` (`id`) ON DELETE CASCADE
                      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; ";
            if($mysqli->query($sql) === TRUE){
                
            }else {
                echo "error creating membership:". $mysqli->error;
            }
        }
    }
    if($result = $mysqli->query("SHOW TABLES LIKE 'share_winner'")){
        if(!$result->num_rows == 1) {
            $sql =" CREATE TABLE `share_winner` (
                        `id` int(5) NOT NULL AUTO_INCREMENT,
                        `winner_id` int(5) NOT NULL,
                        `contest_id` int(5) NOT NULL,
                        `warned` int(1) DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `winner_id` (`winner_id`,`contest_id`),
                        KEY `contest_id` (`contest_id`),
                        CONSTRAINT `share_winner_ibfk_1` FOREIGN KEY (`winner_id`) REFERENCES `contest` (`winner`) ON DELETE CASCADE,
                        CONSTRAINT `share_winner_ibfk_2` FOREIGN KEY (`contest_id`) REFERENCES `contest` (`id`) ON DELETE CASCADE
                      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            if($mysqli->query($sql) === TRUE){
                
            }else{
                echo "Error creating share_winner:". $mysqli->error;
            }
        }
    }
    if($result = $mysqli->query("SHOW TABLES LIKE 'chat'")){
        if(!$result->num_rows == 1) {
            $sql = "CREATE TABLE `chat` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `username` varchar(32) NOT NULL,
                `text` varchar(128) NOT NULL,
                `group_id` int(5) NOT NULL,
                PRIMARY KEY (`id`),
                KEY `group_id` (`group_id`)
                FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE
              ) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;";
            if($mysqli->query($sql) === TRUE){
                
            }else{
                echo "ERROR creating chat:". $mysqli->error;
            }
        }
    }
  

 ?>
