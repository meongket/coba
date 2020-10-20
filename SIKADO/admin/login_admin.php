<?php
	session_start();
	//$server = “localhost”; //ganti sesuai server Anda
	// Include our login information
	require_once('db_login.php');

	// Connect
	$db = mysqli_connect($db_host, $db_username, $db_password,$db_database);
	if (mysqli_connect_errno())
	{
		die ("Could not connect to the database: <br />". mysqli_connect_error( ));
	}
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	//Querynya
	$query = "SELECT username, password FROM admin WHERE username = '$username' and password = '$password' ";
	
	// Execute the query
	$result = mysqli_query($db,$query);
	
	if (!$result)
	{
		die ("Could not query the database: <br />". mysqli_error($db));
	}
	$row = $result->fetch_object();
	$match = mysqli_num_rows($result);
	if (!empty($username && $password))
	{
		if ($match == 1)
		{	
			$_SESSION['namax'] = $row->nama;
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['password'] = $_POST['password'];
			header("Location:dosen/view_dosen.php");
		}
		else
		{
			echo '<script language="javascript">alert("Kombinasi email dan password salah! Silahkan inputkan kembali"); document.location="index.html";</script>';
		}
	}
	else
	{
		echo '<script language="javascript">alert("Username dan Passworrd wajib diisi"); document.location="index.html";</script>';
	}
	

?>
