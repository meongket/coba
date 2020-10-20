<?php
	require_once('../../db_login.php');
	require_once	('../../redirecter.php');
	//session_start();
	if (isset($_SESSION['username'])&& ($_SESSION['password']))
	{
		$db = new mysqli($db_host, $db_username, $db_password, $db_database);

		$id2 = $_GET['id'];
		$query = "SELECT id_pengabdian FROM jadwal WHERE id_jadwal = '".$id2."'";
		$result = $db->query( $query );
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			$row = $result->fetch_object();
			$id = $row->id_pengabdian;
		}
		$query1 = "DELETE FROM jadwal WHERE id_jadwal = '".$id2."' ";
		// Execute the query
		$result1 = $db->query($query1);
		if (!$result1)
		{
			 die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Data berhasil dihapuskan"); document.location="view_rangkaian_pengabdian.php?id='.$id.'";</script>';
			$db->close();
			exit;
		}
	}
	else
	{
		echo '<script language="javascript">alert("Anda Belum Login, Silahkan Login terlebih dahulu"); document.location="../../../index.html";</script>';
	}
?>
