<?php
	require_once('redirecter.php');
/*---------------------Fungsi test input---------------------------------------------------------*/
	function test_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

/*---------------------Fungsi autoincrement---------------------------------------------------------*/
	 function kodeauto($tabel,$kolom,$kodeawal)
	 {
		 include('db_login.php');

		 // membuat query max
		 $carikode = mysqli_query($db, "SELECT max(".$kolom.") from ".$tabel." ") or die (mysqli_error());
		 $datakode = mysqli_fetch_array($carikode);

		 if ($datakode) {
			 $nilaikode = substr($datakode[0], 1);

			 // menjadikan $nilaikode ( int )
			 $kode = (int) $nilaikode;

			 // setiap $kode di tambah 1
			 $kode = $kode + 1;
			 $kode_otomatis = $kodeawal.str_pad($kode, 4, "0", STR_PAD_LEFT);
		 }
		 else {
			 $kode_otomatis = $kodeawal."0001";
		 }

		 return $kode_otomatis;
	 }
	 function view_foto($id)
	{
		include('db_login.php');
		$query = "SELECT * FROM dosen WHERE nip = '".$id."' ";
		// Execute the query
		$result = $db->query($query);
		if (!$result)
		{
			 die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			while ($row = $result->fetch_object())
			{	
				if($row->foto==null){
				echo '<img class="user-image img-responsive" src="foto/find_user.png"width="123px" height="123px" alt="">';
				}
				else{
				echo '<img class="user-image img-responsive" src="foto/'.$row->foto.'"width="123px" height="123px" alt="">';
				}
			}
		}
		$result->free();
		$db->close();
	}
/*----------------Fungsi Akun Dosen----------------------------------------------------*/
	function view_profil_dosen($id)
	{
		include('db_login.php');
		$query = "SELECT * FROM dosen WHERE nip = '".$id."' ";
		// Execute the query
		$result = $db->query($query);
		if (!$result)
		{
			 die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			while ($row = $result->fetch_object())
			{	
				echo '<center>';
				if($row->foto==null){
				echo '<img class="img-responsive" src="foto/find_user.png"width="223px" height="300px" alt="">';
				}
				else{
				echo '<img class="img-responsive" src="foto/'.$row->foto.'"width="223px" height="300px" alt="">';
				}
				echo '<br/>';
				echo '</center>';
				echo '<table class="table">';
					echo '<tr>';
						echo '<td><label>NIP</label></td>';
						echo '<td><label>:</label></td>';
						echo '<td><label>'.$row->nip.'</label></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td><label>NIDN</label></td>';
						echo '<td><label>:</label></td>';
						echo '<td><label>'.$row->nidn.'</label></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td><label>Nama</label></td>';
						echo '<td><label>:</label></td>';
						echo '<td><label><span>'.$row->gelar_depan.'</span><span>'.$row->nama.'</span><span>'.$row->gelar_belakang.'</span></label></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td><label>Tempat Lahir</label></td>';
						echo '<td><label>:</label></td>';
						echo '<td><label>'.$row->tempat_lahir.'</label></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td><label>Tanggal Lahir</label></td>';
						echo '<td><label>:</label></td>';
						echo '<td><label>'.$row->tanggal_lahir.'</label></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td><label>Email</label></td>';
						echo '<td><label>:</label></td>';
						echo '<td><label>'.$row->email.'</label></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td><label>Alamat Rumah</label></td>';
						echo '<td><label>:</label></td>';
						echo '<td><label>'.$row->alamat_rumah.'</label></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td><label>Nomor HP</label></td>';
						echo '<td><label>:</label></td>';
						echo '<td><label>'.$row->no_hp.'</label></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<td><label>Scopus ID</label></td>';
						echo '<td><label>:</label></td>';
						echo '<td><label>'.$row->scopus_id.'</label></td>';
					echo '</tr>';
				echo '</table>';
			}
		}
		$result->free();
		$db->close();
	}

	function edit_profil_dosen($nip,$nidn,$gelar_depan,$nama,$gelar_belakang,$email,$tempat_lahir,$tanggal_lahir,$alamat_rumah,$no_hp,$scopus_id)
	{
		include ('db_login.php');
		$query = "UPDATE dosen SET nidn = '".$nidn."', gelar_depan = '".$gelar_depan."', nama = '".$nama."', gelar_belakang = '".$gelar_belakang."', email = '".$email."',
				 tempat_lahir = '".$tempat_lahir."', tanggal_lahir = '".$tanggal_lahir."', alamat_rumah = '".$alamat_rumah."', no_hp = '".$no_hp."', scopus_id = '".$scopus_id."'
				 WHERE nip = '".$nip."' ";

		// Execute the query
		$result = $db->query( $query );
		if (!$result)
		{
			 die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
						window.alert('Succesfully Updated')
						window.location.href='view_profil_dosen.php';
						</SCRIPT>");
			$db->close();
			exit;
		}
	}

	function ganti_password_dosen($id,$password_baru)
	{
		include ('db_login.php');
		$query = "UPDATE dosen SET password = '".$password_baru."' WHERE nip = '".$id."' ";
		// Execute the query
		$result = $db->query( $query );
		if (!$result)
		{
			 die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Data berhasil diganti. Data yang dimasukkan memiliki password = '.$password_baru.'"); document.location="../jadwal/view_jadwal.php";</script>';
			$db->close();
			exit;
		}
	}

	function force_ganti_password_dosen($id,$password_baru)
	{
		include ('db_login.php');
		$query = "UPDATE dosen SET password = '".$password_baru."', tgl_login = '".date('Y-m-d')."' WHERE nip = '".$id."' ";
		// Execute the query
		$result = $db->query( $query );
		if (!$result)
		{
			 die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Data berhasil diganti. Data yang dimasukkan memiliki password = '.$password_baru.'"); document.location="../jadwal/view_jadwal.php";</script>';
			$db->close();
			exit;
		}
	}

	/*----------------Fungsi Jadwal----------------------------------------------------*/
	function view_jadwal($nip,$tanggal)
		{
			include ('db_login.php');
			$query = "SELECT * FROM jadwal WHERE nip = '".$nip."'
											AND tanggal = '".$tanggal->format('Y-m-d')."' ";

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
							echo '<td>'.$row->nama_acara.'</td> ';
							echo '<td>'.$row->waktu_mulai.'</td> ';
							echo '<td>'.$row->waktu_selesai.'</td> ';
							echo '<td>'.$row->tempat.'</td> ';
							echo '<td>'.$row->keterangan.'</td> ';
							
						echo '</tr>';
						$i++;
					}
					echo'</tbody>';
					$result->free();
					$db->close();
				}
			}
		}

		function edit_jadwal($id_jadwal,$nama_acara,$tanggal,$waktu_mulai,$waktu_selesai,$tempat,$keterangan)
		{
			include ('db_login.php');
			$query = "UPDATE jadwal SET nama_acara='".$nama_acara."', tanggal='".$tanggal."', waktu_mulai='".$waktu_mulai."', waktu_selesai='".$waktu_selesai."',
					tempat='".$tempat."', keterangan='".$keterangan."'
					WHERE id_jadwal = ".$id_jadwal." ";
			// Execute the query
			$result = $db->query($query);
			if (!$result)
			{
				die ("Could not query the database: <br />". $db->error);
			}
			else
			{
				echo '<script language="javascript">alert("Data berhasil diupdate"); document.location="view_jadwal.php";</script>';
				$db->close();
				exit;
			}
		}

	/*----------------Fungsi Pendidikan----------------------------------------------------*/
	function view_pendidikan($nip)
	{
		include ('db_login.php');
		$query = "SELECT * FROM jadwal WHERE nip = '".$nip."'
					AND jenis_kegiatan = 'A'";

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
						echo '<td>'.$row->nama_acara.'</td> ';
						echo '<td>'.$row->tanggal.'</td> ';
						echo '<td>'.$row->waktu_mulai.'</td> ';
						echo '<td>'.$row->waktu_selesai.'</td> ';
						echo '<td>'.$row->tempat.'</td> ';
						echo '<td>'.$row->keterangan.'</td> ';
						echo '<td><a style = "margin-right:10px; margin-bottom:3px;margin-top:3px" class="btn btn-primary" href="edit_pendidikan.php?id_jadwal='.$row->id_jadwal.' "><i class="fa fa-edit"></i>  Edit </a>
						<span><a style = "margin-bottom:3px;margin-top:3px" class="btn btn-danger" href="#" onclick="Konf1('.$row->id_jadwal.')"> <i class="fa fa-trash-o"></i> Hapus </a></span></td>';
					echo '</tr>';
					$i++;
				}
				echo '</tbody>';
				$result->free();
				$db->close();
			}
		}
	}

	function add_pendidikan($nip,$nama_acara,$tanggal,$waktu_mulai,$waktu_selesai,$tempat,$id_pendidikan,$keterangan)
	{
		include ('db_login.php');
		$query = "INSERT INTO jadwal (nip,nama_acara,tanggal,waktu_mulai,waktu_selesai,tempat,jenis_kegiatan,id_pendidikan,keterangan)
							VALUES ('$nip','$nama_acara','$tanggal','$waktu_mulai','$waktu_selesai','$tempat','A','$id_pendidikan','$keterangan') ";
		// Execute the query
		$result = $db->query($query);
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Data berhasil ditambahkan"); document.location="view_pendidikan.php";</script>';
			$db->close();
			exit;
		}
	}

	function edit_pendidikan($id_jadwal,$nama_acara,$tanggal,$waktu_mulai,$waktu_selesai,$tempat,$keterangan)
	{
		include ('db_login.php');
		$query = "UPDATE jadwal SET nama_acara='".$nama_acara."', tanggal='".$tanggal."', waktu_mulai='".$waktu_mulai."', waktu_selesai='".$waktu_selesai."',
				tempat='".$tempat."', keterangan='".$keterangan."'
				WHERE id_jadwal = ".$id_jadwal." ";
		// Execute the query
		$result = $db->query($query);
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Data berhasil diupdate"); document.location="view_pendidikan.php";</script>';
			$db->close();
			exit;
		}
	}
/*----------------Fungsi Penelitian----------------------------------------------------*/
	function view_penelitian ($id)
	{
		include ('db_login.php');
		$query = "SELECT * FROM penelitian WHERE nip = '".$id."' ";

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
				// Advanced Tables
               echo'<tbody>';
				while ($row = $result->fetch_object())
				{
					echo '<tr>';
						echo '<td>'.$i.'</td>';
						echo '<td>'.$row->judul.'</td> ';
						echo '<td>'.$row->skim.'</td> ';
						echo '<td>'.$row->tgl_mulai.'</td> ';
						echo '<td>'.$row->tgl_selesai.'</td> ';
						echo '<td>'.$row->sumber_dana.'</td> ';
						echo '<td><a href="file_upload/'.$row->output.'">'.$row->output.'</td> ';
						echo '<td><a style = "margin-right:10px; margin-top:3px; margin-bottom:3px" class="btn btn-outline btn-default" href="rangkaian/view_rangkaian_penelitian.php?id='.$row->id_penelitian.'"> Agenda </a>
						<span><a style = "margin-top:3px; margin-bottom:3px" class="btn btn-primary" href="edit_penelitian.php?id='.$row->id_penelitian.'"><i class="fa fa-edit"></i> Edit </a></span></td>';
					echo '</tr>';
					$i++;
				}
				echo'</tbody>';
				$result->free();
				$db->close();
			}
		}
 	}

	function add_penelitian($id_penelitian,$nip,$judul,$skim,$tgl_mulai,$tgl_selesai,$sumber_dana)
	{
		include ('../db_login.php');
		$query = "INSERT INTO penelitian (id_penelitian,nip,judul,skim,tgl_mulai,tgl_selesai,sumber_dana)
							VALUES ('$id_penelitian','$nip','$judul','$skim','$tgl_mulai','$tgl_selesai','$sumber_dana') ";
		// Execute the query
		$result = $db->query($query);
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
						window.alert('Data berhasil ditambahkan')
						window.location.href='view_penelitian.php';
						</SCRIPT>");
			$db->close();
			exit;
		}
	}

	function edit_penelitian($id_penelitian,$judul,$skim,$tgl_mulai,$tgl_selesai,$sumber_dana)
	{
		include ('db_login.php');
		$query = "UPDATE penelitian SET judul = '".$judul."', skim = '".$skim."', tgl_mulai = '".$tgl_mulai."' , tgl_selesai = '".$tgl_selesai."', sumber_dana = '".$sumber_dana."'
																		WHERE id_penelitian = '".$id_penelitian."' ";
		// Execute the query
		$result = $db->query($query);
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
						window.alert('Succesfully Updated')
						window.location.href='view_penelitian.php';
						</SCRIPT>");
			$db->close();
			exit;
		}
	}

/*----------------Fungsi Pengabdian----------------------------------------------------*/
	function view_pengabdian ($id)
	{
		include ('db_login.php');
		$query = "SELECT * FROM pengabdian WHERE nip = '".$id."'";
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
						echo '<td>'.$row->judul.'</td> ';
						echo '<td>'.$row->skim.'</td> ';
						echo '<td>'.$row->tgl_mulai.'</td> ';
						echo '<td>'.$row->tgl_selesai.'</td> ';
						echo '<td>'.$row->sumber_dana.'</td> ';
						echo '<td><a style="margin-right:10px;margin-bottom:3px;margin-top:3px" class="btn btn-outline btn-default" href="rangkaian/view_rangkaian_pengabdian.php?id='.$row->id_pengabdian.'"> Agenda </a>
						<span><a style = "margin-bottom:3px;margin-top:3px" class="btn btn-primary" href="edit_pengabdian.php?id='.$row->id_pengabdian.'"><i class="fa fa-edit"></i>  Edit </a></span></td>';
					echo '</tr>';
					$i++;
				}
				echo'</tbody>';
				$result->free();
				$db->close();
			}
		}
	}

	function add_pengabdian($id_pengabdian,$nip,$judul,$skim,$tgl_mulai,$tgl_selesai,$sumber_dana)
	{
		include ('db_login.php');
		$query = "INSERT INTO pengabdian (id_pengabdian,nip,judul,skim,tgl_mulai,tgl_selesai,sumber_dana)
					VALUES ('$id_pengabdian','$nip','$judul','$skim','$tgl_mulai','$tgl_selesai','$sumber_dana') ";
		// Execute the query
		$result = $db->query($query);
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
						window.alert('Data berhasil ditambahkan')
						window.location.href='view_pengabdian.php';
						</SCRIPT>");

			$db->close();
			exit;
		}
	}

	function edit_pengabdian($id_pengabdian,$judul,$skim,$tgl_mulai,$tgl_selesai,$sumber_dana)
	{
		include ('db_login.php');
		$query = "UPDATE pengabdian SET judul='".$judul."', skim='".$skim."', tgl_mulai='".$tgl_mulai."', tgl_selesai='".$tgl_selesai."', sumber_dana='".$sumber_dana."'
				  WHERE id_pengabdian ='".$id_pengabdian."' ";
		// Execute the query
		$result = $db->query($query);
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
						window.alert('Succesfully Updated')
						window.location.href='view_pengabdian.php';
						</SCRIPT>");
			$db->close();
			exit;
		}
	}

	/*----------------Fungsi Detail Penelitian (Rangkaian)----------------------------------------------------*/
	function view_rangkaian_penelitian($nip,$id)
	{
		include ('db_login.php');
		$query = "SELECT * FROM jadwal WHERE nip = '".$nip."'
										AND jenis_kegiatan = 'B'
										AND id_penelitian = '".$id."' ";

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
						echo '<td>'.$row->nama_acara.'</td> ';
						echo '<td>'.$row->tanggal.'</td> ';
						echo '<td>'.$row->waktu_mulai.'</td> ';
						echo '<td>'.$row->waktu_selesai.'</td> ';
						echo '<td>'.$row->tempat.'</td> ';
						echo '<td>'.$row->keterangan.'</td> ';
						echo '<td><a style = "margin-right:10px;margin-top:3px;margin-bottom:3px"class="btn btn-primary" href="edit_rangkaian_penelitian.php?id_jadwal='.$row->id_jadwal.'&id_penelitian='.$row->id_penelitian.' "><i class="fa fa-edit"></i> Edit </a>
						<span><a style = "margin-top:3px;margin-bottom:3px" class="btn btn-danger" href= "#" onclick="Konf1('.$row->id_jadwal.')"><i class="fa fa-trash-o"></i> Hapus </a></span></td>';
					echo '</tr>';
					$i++;
				}
				echo'</tbody>';
				$result->free();
				$db->close();
			}
		}
	}

	function add_rangkaian_penelitian($nip,$nama_acara,$tanggal,$waktu_mulai,$waktu_selesai,$tempat,$id_penelitian,$keterangan)
	{
		include ('db_login.php');
		$query = "INSERT INTO jadwal (nip,nama_acara,tanggal,waktu_mulai,waktu_selesai,tempat,jenis_kegiatan,id_penelitian,keterangan)
							VALUES ('$nip','$nama_acara','$tanggal','$waktu_mulai','$waktu_selesai','$tempat','B','$id_penelitian','$keterangan') ";
		// Execute the query
		$result = $db->query($query);
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Data berhasil ditambahkan"); document.location="view_rangkaian_penelitian.php?id='.$id_penelitian.' ";</script>';
			$db->close();
			exit;
		}
	}

	function edit_rangkaian_penelitian($id_jadwal,$nama_acara,$tanggal,$waktu_mulai,$waktu_selesai,$tempat,$id_penelitian,$keterangan)
	{
		include ('db_login.php');
		$query = "UPDATE jadwal SET nama_acara='".$nama_acara."', tanggal='".$tanggal."', waktu_mulai='".$waktu_mulai."', waktu_selesai='".$waktu_selesai."',
																tempat='".$tempat."', keterangan='".$keterangan."'
																WHERE id_jadwal = ".$id_jadwal." ";
		// Execute the query
		$result = $db->query($query);
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Data berhasil diupdate"); document.location="view_rangkaian_penelitian.php?id='.$id_penelitian.' ";</script>';
			$db->close();
			exit;
		}
	}

	/*----------------Fungsi Detail Pengabdian (Rangkaian)----------------------------------------------------*/
	function view_rangkaian_pengabdian($nip,$id)
	{
		include ('db_login.php');
		$query = "SELECT * FROM jadwal WHERE nip = '".$nip."'
										AND jenis_kegiatan = 'C'
										AND id_pengabdian = '".$id."' ";

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
						echo '<td>'.$row->nama_acara.'</td> ';
						echo '<td>'.$row->tanggal.'</td> ';
						echo '<td>'.$row->waktu_mulai.'</td> ';
						echo '<td>'.$row->waktu_selesai.'</td> ';
						echo '<td>'.$row->tempat.'</td> ';
						echo '<td>'.$row->keterangan.'</td> ';
						echo '<td><a style = "margin-right : 10px;margin-top:3px;margin-bottom3px" class="btn btn-primary" href="edit_rangkaian_pengabdian.php?id_jadwal='.$row->id_jadwal.'&id_pengabdian='.$row->id_pengabdian.' "><i class="fa fa-edit"></i> Edit </a>
						<span><a style = "margin-top:3px;margin-bottom3px" class="btn btn-danger" href= "#" onclick="Konf1('.$row->id_jadwal.')"><i class="fa fa-trash-o"></i> Hapus </a></span>';
						echo '</td>';
					echo '</tr>';
					$i++;
				}
				echo'</tbody>';
				$result->free();
				$db->close();
			}
		}
	}

	function add_rangkaian_pengabdian($nip,$nama_acara,$tanggal,$waktu_mulai,$waktu_selesai,$tempat,$id_pengabdian,$keterangan)
	{
		include ('db_login.php');
		$query = "INSERT INTO jadwal (nip,nama_acara,tanggal,waktu_mulai,waktu_selesai,tempat,jenis_kegiatan,id_pengabdian,keterangan)
							VALUES ('$nip','$nama_acara','$tanggal','$waktu_mulai','$waktu_selesai','$tempat','C','$id_pengabdian','$keterangan') ";
		// Execute the query
		$result = $db->query($query);
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Data berhasil ditambahkan"); document.location="view_rangkaian_pengabdian.php?id='.$id_pengabdian.' ";</script>';
			$db->close();
			exit;
		}
	}

	function edit_rangkaian_pengabdian($id_jadwal,$nama_acara,$tanggal,$waktu_mulai,$waktu_selesai,$tempat,$id_pengabdian,$keterangan)
	{
		include ('db_login.php');
		$query = "UPDATE jadwal SET nama_acara='".$nama_acara."', tanggal='".$tanggal."', waktu_mulai='".$waktu_mulai."', waktu_selesai='".$waktu_selesai."',
																tempat='".$tempat."', keterangan='".$keterangan."'
																WHERE id_jadwal = ".$id_jadwal." ";
		// Execute the query
		$result = $db->query($query);
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Data berhasil diupdate"); document.location="view_rangkaian_pengabdian.php?id='.$id_pengabdian.' ";</script>';
			$db->close();
			exit;
		}
	}

?>

	<!-- DATA TABLE SCRIPTS -->
	<script src="../../assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="../../assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
         <!-- CUSTOM SCRIPTS -->
    <script src="../../assets/js/custom.js"></script>
	</body>
	</body>
</html>
