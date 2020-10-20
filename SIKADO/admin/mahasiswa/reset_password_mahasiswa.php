<?php
	require_once('../fungsiAdmin.php');
	require_once('../db_login.php');
	session_start();
	if (isset($_SESSION['username'])&& ($_SESSION['password']))
	{
		$id = $_GET['id'];
		reset_password_mahasiswa($id);
	}
	else
	{
		echo '<script language="javascript">alert("Anda Belum Login, Silahkan Login terlebih dahulu"); document.location="../login.html";</script>';
	}
?>		
