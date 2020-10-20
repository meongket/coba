<?php
	require_once('../db_login.php');
	session_start();
	if (isset($_SESSION['username'])&& ($_SESSION['password']))
	{
		$db = new mysqli($db_host, $db_username, $db_password, $db_database);
		
		$id = $_GET['id'];
		$query = "DELETE FROM dosen WHERE nip = '".$id."' ";
		// Execute the query
		$result = $db->query( $query );
		if (!$result)
		{
			 die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Data berhasil dihapuskan"); document.location="view_dosen.php";</script>';
			$db->close();
			exit;
		}
	}
	else
	{
		echo '<script language="javascript">alert("Anda Belum Login, Silahkan Login terlebih dahulu"); document.location="../login.html";</script>';
	}	
?>		
