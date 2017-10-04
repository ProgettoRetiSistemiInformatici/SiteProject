<?php

session_start();

session_unset($_SESSION["utente"]);

header("Location: /index.php");

?>