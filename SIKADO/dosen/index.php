<?php
	require_once  ("db_login.php");
	session_start();
	if (isset($_SESSION['username'])&& ($_SESSION['password'])){
		if ($_SESSION['hak_akses'] == "2")
		{
			header("Location: blank_dosen.php");
		}
		else {
			header("Location: ../index.php");
		}
	}
	else {
		header("Location: ../index.php");
	}
	
?>
