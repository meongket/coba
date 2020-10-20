<?php
	require_once  ("db_login.php");
	session_start();
	if (isset($_SESSION['id_user'])&& ($_SESSION['password'])){
		if ($_SESSION['hak_akses'] != "3"){
			header("Location: ../index.php");
			die();
		}
	}
	else {
		header("Location: ../index.php");
	}
?>
