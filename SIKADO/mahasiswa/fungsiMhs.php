<?php
	require_once('redirecter.php');
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
        echo '<p>Belum Ada Data yang Dimasukkan</p>';
      }
      else
      {
        // Fetch and display the results
        $i=1;
        echo '<tbody>';

        while ($row = $result->fetch_object())
        {
          echo '<tr>';
          echo '<td>'.$i.'</td>';
          echo '<td>'.$row->nip.'</td> ';
          echo '<td>'.$row->gelar_depan.' '.$row->nama.' '.$row->gelar_belakang.'</td>';
          echo '<td><a data-toggle="tooltip" title = "jadwal" class="btn btn-warning" href="lihat_jadwal/jadwal_dosen.php?id='.$row->nip.'"><i class="fa fa-calendar" aria-hidden="true"></i></a></td>';
          echo '</tr>';
          $i++;
        }
        echo '</tbody>';
        echo '</table>';
        echo '<br />';
        $result->free();
        $db->close();
      }
    }
  }

  /*-----------------Fungsi Lihat Jadwal oleh mahasiswa----------------------------------------------------*/
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

	?>
