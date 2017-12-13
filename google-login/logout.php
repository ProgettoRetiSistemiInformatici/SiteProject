<?php
	require_once "config.php";

<<<<<<< HEAD
	if(isset($_SESSION['access_token'])){
		unset($_SESSION['access_token']);
		$gClient->revokeToken();
	}
	
	unset($_SESSION['utente']);
=======
	unset($_SESSION['access_token']);

	$gClient->revokeToken();
>>>>>>> c4e8eed04fa369e772f4e2be70136ba753273096

	session_destroy();

	header('Location: ../index.php');

	exit();
?>
