<?php
	function test_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	require_once ("db_login.php");
	session_start();
	$username = $_POST['username'];
	$password = $_POST['password'];

	//Di filter dulu
	$username = test_input($username);
	$password = test_input($password);

	if ($username == "" && $password == "")
	{
		echo '<script language="javascript">alert("Username dan password kosong"); document.location="../index.html"; </script>';
	}
	elseif ($username == "" && $password != "")
	{
		echo '<script language="javascript">alert("Username kosong"); document.location="../index.html"; </script>';
	}
	elseif ($username != "" && $password == "")
	{
		echo '<script language="javascript">alert("Password kosong"); document.location="../index.html"; </script>';
	}
	else
	{
		$query  = "SELECT * FROM dosen WHERE nip = '$username' AND password = '$password'";
		// Execute the query
		$result = mysqli_query($db,$query);
		if (!$result)
		{
			die ("Could not query the database: <br />". mysqli_error($db));
		}
		$row = $result -> fetch_object();
		$match = mysqli_num_rows ($result);

		//Mengecek apakah sudah ada, jika ada row nya 1
		if ($match == 1)
		{
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['password'] = $_POST['password'];
			$_SESSION['nama']	  = $row->gelar_depan.$row->nama.$row->gelar_belakang;
			$_SESSION['hak_akses'] = $row->hak_akses;
			$tgl_login1 = $row->tgl_login;
			$username = $_SESSION['username'];
			if ($tgl_login1 == "0000-00-00")
			{
				header("Location:../dosen/akun/force_ganti_password.php?id=".$username."");
			}
			else
			{
				header("Location:../dosen/jadwal/view_jadwal.php");
			}

		}
		else
		{
			$query2  = "SELECT * FROM mahasiswa WHERE nim = '$username' AND password = '$password'";
			$result2 = mysqli_query($db,$query2);
			if (!$result2)
			{
				die ("Could not query the database: <br />". mysqli_error($db));
			}
			$row2 = $result2 -> fetch_object();
			$match2 = mysqli_num_rows ($result2);
			if ($match2 == 1)
			{
				$_SESSION['id_user'] = $_POST['username'];
				$_SESSION['username'] = $row2->nama;
				$_SESSION['nama'] = $row2->nama;
				$_SESSION['password'] = $_POST['password'];
				$_SESSION['hak_akses'] = $row2->hak_akses;

				header("Location:../mahasiswa/blank_mahasiswa.php");
			}
			else
			{
				$query3  = "SELECT * FROM kadep WHERE username = '$username' AND password = '$password'";
				$result3 = mysqli_query($db,$query3);
				if (!$result3)
				{
					die ("Could not query the database: <br />". mysqli_error($db));
				}
				$row3 = $result3 -> fetch_object();
				$match3 = mysqli_num_rows ($result3);

				//Mengecek apakah sudah ada, jika ada row nya 1
				if ($match3 == 1)
				{
					$_SESSION['username'] = $_POST['username'];
					$_SESSION['nama'] 	  = $_POST['username'];
					$_SESSION['password'] = $_POST['password'];
					$_SESSION['hak_akses'] = $row3->hak_akses;
					$tgl_login2 = $row3->tgl_login;
					if ($tgl_login2 == "0000-00-00")
					{
						header("Location:../kadep/akun/force_ganti_password.php");
					}
					else
					{
						header("Location:../kadep/blank_kadep.php");
					}
				}
				else
				{
					echo '<script language="javascript">alert("Kombinasi username dan password salah. Silahkan login kembali"); document.location="../index.html"; </script>';
				}
			}
		}
	}
	//Querynya

?>
