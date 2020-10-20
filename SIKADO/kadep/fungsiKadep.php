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
/*-----------------Fungsi Akun Kadep----------------------------------------------------*/
  function ganti_password_kadep($password_baru)
  {
    include ('db_login.php');
    $query = "UPDATE kadep SET password = '".$password_baru."' WHERE username = 'kadep' ";
    // Execute the query
    $result = $db->query( $query );
    if (!$result)
    {
      die ("Could not query the database: <br />". $db->error);
    }
    else
    {
      echo '<script language="javascript">alert("Data berhasil diganti. Data yang dimasukkan memiliki password = '.$password_baru.'"); document.location="../blank_kadep.php";</script>';
      $db->close();
      exit;
    }
  }

	function force_ganti_password_kadep($password_baru)
	{
		include ('db_login.php');
		$query = "UPDATE kadep SET password = '".$password_baru."', tgl_login = '".date('Y-m-d')."' WHERE username = 'kadep' ";
		// Execute the query
		$result = $db->query( $query );
		if (!$result)
		{
			 die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			echo '<script language="javascript">alert("Data berhasil diganti. Data yang dimasukkan memiliki password = '.$password_baru.'"); document.location="../blank_kadep.php";</script>';
			$db->close();
			exit;
		}
	}

/*-----------------Fungsi Lihat daftar dosen oleh kadep----------------------------------------------------*/
  function view_dosen ()
  {
    include ('db_login.php');
    $query = "SELECT nip, gelar_depan, nama, gelar_belakang FROM dosen ";

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
			  echo '<td>'.$row->nip.'</td> ';
			  echo '<td>'.$row->gelar_depan.' '.$row->nama.' '.$row->gelar_belakang.'</td>';
			  echo '<td><a data-toggle="tooltip" title = "Jadwal" class="btn btn-warning" href="lihat_jadwal/jadwal_dosen.php?id='.$row->nip.'"><i class="fa fa-calendar" aria-hidden="true"></i></a>
					<span><a data-toggle="tooltip" title = "Kegiatan" class="btn btn-info" href="lihat_kegiatan/kegiatan_dosen.php?id='.$row->nip.'"><i class="fa fa-table"></i></a></span>
					<span><a data-toggle="tooltip" title = "Profil" class="btn btn-primary" href="lihat_profil/profil_dosen.php?id='.$row->nip.'"><i class="fa fa-user"></i></a></td></span>';
			
          echo '</tr>';
          $i++;
        }
        echo '</tbody>';
        $result->free();
        $db->close();
      }
    }
  }

	/*-----------------Fungsi Lihat Jadwal oleh kadep----------------------------------------------------*/
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

        function view_nama_dosen($nip)
        {
                include ('db_login.php');
                $query = "SELECT gelar_depan, nama, gelar_belakang FROM dosen
                                                    WHERE nip = '".$nip."' ";

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
                        echo '<p>Unknown</p>';
                    }
                    else
                    {
                        while ($row = $result->fetch_object())
                        {
                                echo $row->gelar_depan.$row->nama.$row->gelar_belakang;
                        }
                        $result->free();
                        $db->close();
                    }
                }
            }

  /*-----------------Fungsi Lihat Kegiatan oleh kadep----------------------------------------------------*/
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
				echo'Maaf Anda Belum Memiliki Agenda';
			}
			else
			{
				// Fetch and display the results
				$i=1;
				echo '<table border="1" class="table table-striped table-bordered table-hover">';
				echo '<tr>';
				echo '<th> No </th>';
				echo '<th> Nama Acara </th>';
				echo '<th> Tanggal </th>';
				echo '<th> Waktu Mulai </th>';
				echo '<th> Waktu Selesai </th>';
				echo '<th> Tempat </th>';
				echo '<th> Keterangan </th>';
				echo '</tr>';


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
					echo '</tr>';
					$i++;
				}
				echo'</table>';
				$result->free();
				$db->close();
			}
		}
	}

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
				echo'Maaf Anda Belum Memasukkan Data Penelitian';
			}
			else
			{
				// Fetch and display the results
				$i=1;
				echo '<table border="1" class="table table-striped table-bordered table-hover">';
				echo '<tr>';
				echo '<th> No </th>';
				echo '<th> Judul </th>';
				echo '<th> Skim </th>';
				echo '<th> Waktu Mulai </th>';
				echo '<th> Waktu Selesai </th>';
				echo '<th> Sumber Dana </th>';
				echo '<th> Output </th>';
				echo '</tr>';

				while ($row = $result->fetch_object())
				{
					echo '<tr>';
					echo '<td>'.$i.'</td>';
					echo '<td>'.$row->judul.'</td> ';
					echo '<td>'.$row->skim.'</td> ';
					echo '<td>'.$row->tgl_mulai.'</td> ';
					echo '<td>'.$row->tgl_selesai.'</td> ';
					echo '<td>'.$row->sumber_dana.'</td> ';
					echo '<td>'.$row->output.'</td> ';
					echo '</tr>';
					$i++;
				}
				echo'</table>';
				$result->free();
				$db->close();
			}
		}
 	}

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
			echo'Maaf Anda Belum Memasukkan Data Pengabdian';
			}
			else
			{
				// Fetch and display the results
				$i=1;
				echo '<table border="1" class="table table-striped table-bordered table-hover">';
				echo '<tr>';
					echo '<th> No </th>';
					echo '<th> Judul </th>';
					echo '<th> Skim </th>';
					echo '<th> Tanggal Mulai </th>';
					echo '<th> Tanggal Selesai </th>';
					echo '<th> Sumber Dana </th>';
				echo '</tr>';

				while ($row = $result->fetch_object())
				{
					echo '<tr>';
						echo '<td>'.$i.'</td>';
						echo '<td>'.$row->judul.'</td> ';
						echo '<td>'.$row->skim.'</td> ';
						echo '<td>'.$row->tgl_mulai.'</td> ';
						echo '<td>'.$row->tgl_selesai.'</td> ';
						echo '<td>'.$row->sumber_dana.'</td> ';
					echo '</tr>';
					$i++;
				}
				echo'</table>';
				$result->free();
				$db->close();
			}
		}
	}

/*-----------------Fungsi Lihat Profil oleh kadep----------------------------------------------------*/
  function view_profil_dosen($id)
  {
    include('../db_login.php');
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
        echo '<table class="table table-hover table-striped">';
          echo '<tr>';
            echo '<th>NIP</th>';
            echo '<td>:</td>';
            echo '<td>'.$row->nip.'</td>';
          echo '</tr>';
          echo '<tr>';
            echo '<th>NIDN</th>';
            echo '<td>:</td>';
            echo '<td>'.$row->nidn.'</td>';
          echo '</tr>';
          echo '<tr>';
            echo '<th>Nama</th>';
            echo '<td>:</td>';
            echo '<td><span>'.$row->gelar_depan.'</span><span>'.$row->nama.'</span><span>'.$row->gelar_belakang.'</span></td>';
          echo '</tr>';
          echo '<tr>';
            echo '<th>Tempat Lahir</th>';
            echo '<td>:</td>';
            echo '<td>'.$row->tempat_lahir.'</td>';
          echo '</tr>';
          echo '<tr>';
            echo '<th>Tanggal Lahir</th>';
            echo '<td>:</td>';
            echo '<td>'.$row->tanggal_lahir.'</td>';
          echo '</tr>';
          echo '<tr>';
            echo '<th>Alamat Rumah</th>';
            echo '<td>:</td>';
            echo '<td>'.$row->alamat_rumah.'</td>';
          echo '</tr>';
          echo '<tr>';
            echo '<th>Nomor HP</th>';
            echo '<td>:</td>';
            echo '<td>'.$row->no_hp.'</td>';
          echo '</tr>';
          echo '<tr>';
            echo '<th>Scopus ID</th>';
            echo '<td>:</td>';
            echo '<td>'.$row->scopus_id.'</td>';
          echo '</tr>';
        echo '</table>';
      }
    }
    $result->free();
    $db->close();
  }


?>
