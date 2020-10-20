<?php
/*--------------------------------------------------Fungsi test input---------------------------------------------------------*/
	function test_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
/*--------------------------
------------Fungsi kelola dosen oleh admin----------------------------------------------------*/	
	function add_dosen($nip,$nidn,$gelar_depan,$nama,$gelar_belakang,$password,$email,$tempat_lahir,$tanggal_lahir,$alamat_rumah,$no_hp,$scopus_id)
	{
		include ('db_login.php');
		$hak_akses = 2;
		$query = "INSERT INTO dosen (nip,nidn,gelar_depan,nama,gelar_belakang,password,email,tempat_lahir,tanggal_lahir,alamat_rumah,no_hp,scopus_id,hak_akses) 
				  VALUES ('$nip','$nidn','$gelar_depan','$nama','$gelar_belakang','$password','$email','$tempat_lahir','$tanggal_lahir','$alamat_rumah','$no_hp','$scopus_id','$hak_akses') ";
		// Execute the query
		$result = $db->query($query);
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Data berhasil ditambahkan. Semua data yang dimasukkan memiliki password = '.$password.'"); document.location="view_dosen.php";</script>';
			$db->close();
			exit;
		}
	}
	
	function delete_dosen($id)
	{
		include ('db_login.php');
		$query = "DELETE FROM dosen WHERE nip = '".$id."' ";
		// Execute the query
		$result = $db->query($query);
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
	
	function reset_password_dosen($id)
	{
		include ('db_login.php');
		$password = "000000";
		$tgl_login = "0000-00-00";
		$query = "UPDATE dosen SET password = '".$password."', tgl_login ='".$tgl_login."'   WHERE nip = '".$id."' ";
		// Execute the query
		$result = $db->query( $query );
		if (!$result)
		{
			 die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Password berhasil ter-reset menjadi '.$password.' "); document.location="view_dosen.php";</script>';
			$db->close();
			exit;
		}
	}
	
	function view_dosen ()
	{
		include ('db_login.php');
		$query = "SELECT nip, nidn, gelar_depan, nama, gelar_belakang FROM dosen ";
		if(isset($_POST['keyword'])){
				$keyword=$_POST['keyword'];
				$query="SELECT nip, nidn, gelar_depan, nama, gelar_belakang FROM dosen where nama like '%$keyword%'";
			}
		// Execute the query
		$result = $db->query( $query );
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			$totalrow=$result->num_rows;
			if ($totalrow==0)
			{
				echo '<p>Belum Ada Data yang Dimasukkan</p>';
			}
			else
			{
				// Fetch and display the results
				$i=1;
				echo'<tbody>';
				while ($row = $result->fetch_object())
				{
					echo '<tr>';
					echo '<td>'.$i.'</td>';
					echo '<td>'.$row->nip.'</td> ';
					echo '<td>'.$row->nidn.'</td> ';
					echo '<td>'.$row->gelar_depan.' '.$row->nama.' '.$row->gelar_belakang.'</td>'; 
					echo '<td><a style = "margin-right : 15px; margin-bottom : 3px;margin-top : 3px" class="btn btn-success" href="reset_password_dosen.php?id='.$row->nip.'"> <i class="fa fa-refresh"></i>  Reset </a>
						  <span><a style = "margin-bottom : 3px; margin-top : 3px" class="btn btn-danger" href="#" onclick="Konf1('.$row->nip.')"> <i class="fa fa-trash-o"></i>  Delete </a></span></td>';
					echo '</tr>';
					$i++;
				}
				echo '</tbody>';
				$result->free();
				$db->close();
			}
		}
	}
/*--------------------------------------Fungsi kelola mahasiswa oleh admin----------------------------------------------------*/	
	function add_mahasiswa($nim,$nama,$password)
	{
		include ('db_login.php');
		$hak_akses = 3;
		$query = "INSERT INTO mahasiswa (nim,nama,password,hak_akses) VALUES ('$nim','$nama','$password','$hak_akses')";
		// Execute the query
		$result = $db->query( $query );
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Data berhasil ditambahkan. Data yang dimasukkan memiliki password = '.$password.' yaitu NIM"); document.location="view_mahasiswa.php";</script>';
			$db->close();
			exit;
		}
	}
	
	function delete_mahasiswa($id)
	{
		include ('db_login.php');
		$query = "DELETE FROM mahasiswa WHERE nim = '".$id."' ";
		// Execute the query
		$result = $db->query( $query );
		if (!$result)
		{
			 die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Data berhasil dihapuskan"); document.location="view_mahasiswa.php";</script>';
			$db->close();
			exit;
		}	
	}
	
	function reset_password_mahasiswa($id)
	{
		include ('db_login.php');
		$query = "UPDATE mahasiswa SET password = '".$id."' WHERE nim = '".$id."' ";
		// Execute the query
		$result = $db->query( $query );
		if (!$result)
		{
			 die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Password berhasil tereset menjadi '.$id.' "); document.location="view_mahasiswa.php";</script>';
			$db->close();
			exit;
		}
	}
	
	function view_mahasiswa()
	{
		include('db_login.php');
		$query = "SELECT nim, nama FROM mahasiswa ";
		// Execute the query
		$result = $db->query($query);
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			$totalrow=$result->num_rows;
			if ($totalrow==0)
			{
			}
			else
			{
				// Fetch and display the results
				$i=1;
				echo'<tbody>';
				while ($row = $result->fetch_object())
				{
					echo '<tr>';
					echo '<td>'.$i.'</td>';
					echo '<td>'.$row->nim.'</td> ';
					echo '<td>'.$row->nama.'</td>'; 
					echo '<td><a style = "margin-right : 15px; margin-bottom : 3px;margin-top : 3px" class="btn btn-success" href="reset_password_mahasiswa.php?id='.$row->nim.'"> <i class="fa fa-refresh"></i>  Reset </a>
					<span><a style = "margin-bottom : 3px; margin-top : 3px" class="btn btn-danger" href="#" onclick="Konf1('.$row->nim.')"> <i class="fa fa-trash-o"></i>  Delete </a></span></td>';
					echo '</tr>';
					$i++;
				}								
				echo '</tbody>';
				$result->free();
				$db->close();
			}
		}
	}
	
/*--------------------------------------Fungsi kelola kadep oleh admin----------------------------------------------------*/	
	function reset_password_kadep($id)
	{
		include('db_login.php');
		$password = "kadep";
		$tgl_login = "0000-00-00";
		$query = "UPDATE kadep SET password = '".$password."', tgl_login = '".$tgl_login."' WHERE username = '".$id."' ";
		// Execute the query
		$result = $db->query( $query );
		if (!$result)
		{
			 die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Password berhasil tereset menjadi '.$password.' "); document.location="view_kadep.php";</script>';
			$db->close();
			exit;
		}
	}
	
	function view_kadep()
	{
		include ('db_login.php');
		$query = "SELECT * FROM kadep ";
		
		// Execute the query
		$result = $db->query( $query );
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			$totalrow=$result->num_rows;
			if ($totalrow==0)
			{
			}
			else
			{
				// Fetch and display the results
				$i=1;
				echo'<tbody>';
				while ($row = $result->fetch_object())
				{
					echo '<tr>';
					echo '<td>'.$i.'</td>';
					echo '<td>'.$row->username.'</td>'; 
					echo '<td><a class="btn btn-success" href="reset_password_kadep.php?id='.$row->username.'"><i class="fa fa-refresh"></i> Reset </a></td>';
					echo '</tr>';
					echo '<br/>';
					$i++;
				}							
				echo '</tbody>';
				echo '<br />';
				$result->free();
				$db->close();
			}
		}
	}
	
/*--------------------------------------Fungsi kelola kadep oleh admin----------------------------------------------------*/	
	
?>