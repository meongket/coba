<?php require_once('../redirecter.php'); ?>
<html>
  <head>
    <title>Detail Agenda</title>
  </head>
  <body>
    <?php
	if($_POST['rowid']) {
      $id = $_POST['rowid'];
		include "fungsi_indotgl.php";
			$servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "db_sid_statistika";

            // Membuat Koneksi
            $koneksi = new mysqli($servername, $username, $password, $dbname);
            
            // Melakukan Cek Koneksi
            if ($koneksi->connect_error) {
                die("Koneksi Gagal : " . $koneksi->connect_error);
            } 
			else{
				$sql = "SELECT * FROM jadwal WHERE id_jadwal = ".$id." ";
				$result = $koneksi->query($sql);
				foreach ($result as $baris)
				{

			  #Ubah menjadi format tanggal Indonesia untuk tanggal acara
			  $tanggal = tgl_indo($baris['tanggal']);

			  #Merapikan format teks untuk detail acara
			  $keterangan = nl2br($baris['keterangan']);
			  ?>
				 <div class="table-responsive">
			  <table class="table table-striped table-bordered table-hover">
			          <tr>
					       <td>Tanggal</td>
						   <td align="center"> : </td>
						   <td><?php echo"$tanggal"; ?></td>
					  </tr>
            <tr>
					       <td>Nama Acara</td>
						   <td align="center"> : </td>
						   <td><?php echo $baris['nama_acara']; ?></td>
					  </tr>
            <tr>
					       <td>Jam Mulai</td>
						   <td align="center"> : </td>
						   <td><?php echo $baris['waktu_mulai'] ; ?></td>
					  </tr>
            <tr>
					       <td>Jam Selesai</td>
						   <td align="center"> : </td>
						   <td><?php echo $baris['waktu_selesai'] ; ?></td>
					  </tr>
            <tr>
					       <td>Tempat</td>
						   <td align="center"> : </td>
						   <td><?php echo $baris['tempat'] ; ?></td>
					  </tr>
					  <tr>
					       <td>Keterangan</td>
						   <td align="center"> : </td>
						   <td><?php echo "$keterangan" ; ?></td>
					  </tr>
			  </table>
			  </div>
	   </body>
</html>

<?php }
	} 
	}
	$koneksi->close();
	?>
