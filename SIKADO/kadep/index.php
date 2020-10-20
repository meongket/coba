<?php
	require_once  ("db_login.php");
	session_start();
	if (isset($_SESSION['username'])&& ($_SESSION['password'])){
		if ($_SESSION['hak_akses'] == "1")
		{
			header("Location: blank_kadep.php");
		}
		else{
			header("Location: ../index.php");
		}
	}
	else{
		header("Location: ../index.php");
	}
	
?>
