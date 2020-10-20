<?php
	require_once('../db_login.php');
	require_once('../redirecter.php');
	//session_start();
	if (isset($_SESSION['username'])&& ($_SESSION['password']))
	{
		$db = new mysqli($db_host, $db_username, $db_password, $db_database);

		$id = $_GET['id'];
		$query = "DELETE FROM jadwal WHERE id_jadwal = '".$id."' ";
		// Execute the query
		$result = $db->query( $query );
		if (!$result)
		{
			 die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Data berhasil dihapuskan"); document.location="view_pendidikan.php";</script>';
			$db->close();
			exit;
		}
	}
	else
	{
		echo '<script language="javascript">alert("Anda Belum Login, Silahkan Login terlebih dahulu"); document.location="../../index.html";</script>';
	}
?>
