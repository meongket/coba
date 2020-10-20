<?php
	require_once	('../../redirecter.php');
	require_once('../../fungsi_dosen.php');
	require_once('../../../login/db_login.php');
	//session_start();
	if (isset($_SESSION['username']) && ($_SESSION['password']))
	{
		$id_jadwal = $_GET['id_jadwal'];
		$id_user = $_SESSION['username'];
		$id_pengabdian = $_GET['id_pengabdian'];
		$query = "SELECT * FROM pengabdian WHERE id_pengabdian = '".$id_pengabdian."'";
		$result = $db->query($query);
		while ($row = $result->fetch_object())
		{
			$nama_pengabdian = $row->judul;
		}
		$id_user = $_SESSION['username'];

		if (!isset($_POST["submit"]))
		{
			$query = "SELECT * FROM jadwal WHERE id_jadwal = ".$id_jadwal." ";
			$result = $db->query($query);
			if (!$result)
			{
				die ("Could not query the database: <br />". $db->error);
			}
			else
			{
				while ($row = $result->fetch_object())
				{
					$nama_acara = $row->nama_acara;
					$tanggal = $row->tanggal;
					$waktu_mulai = $row->waktu_mulai;
					$waktu_selesai = $row->waktu_selesai;
					$tempat = $row->tempat;
					$keterangan = $row->keterangan;
				}
			}
		}
		else
		{
			//$nip = test_input($_SESSION['username']);
			$nama_acara = test_input($_POST['nama_acara']);
			if ($nama_acara == "")
			{
				$error_nama_acara = "Nama Acara is required";
				$valid_nama_acara = FALSE;
			}
			else
			{
				$valid_nama_acara = TRUE;
			}

			$tanggal = test_input($_POST['tanggal']);
			if ($tanggal == "")
			{
				$error_tanggal = "Tanggal is required";
				$valid_tanggal = FALSE;
			}
			else
			{
				$valid_tanggal = TRUE;
			}

			$waktu_mulai = test_input($_POST['waktu_mulai']);
			if ($waktu_mulai == "")
			{
				$error_waktu_mulai = "Waktu Mulai is required";
				$valid_mulai = FALSE;
			}
			else
			{
				$valid_waktu_mulai = TRUE;
			}

			$waktu_selesai = test_input($_POST['waktu_selesai']);
			if ($waktu_selesai == "")
			{
				$error_waktu_selesai = "Perkiraan waktu selesai is required";
				$valid_waktu_selesai = FALSE;
			}
			else
			{
				$valid_waktu_selesai = TRUE;
			}

			$tempat = test_input($_POST['tempat']);
			if ($tempat == "")
			{
				$error_tempat = "Tempat is required";
				$valid_tempat = FALSE;
			}
			else
			{
				$valid_tempat = TRUE;
			}

			$keterangan = test_input($_POST['keterangan']);

			if ($valid_nama_acara && $valid_tanggal && $valid_waktu_mulai && $valid_waktu_selesai && $valid_tempat)
			{
				$nama_acara = $db->real_escape_string($nama_acara);
				$tanggal = $db->real_escape_string($tanggal);
				$waktu_mulai = $db->real_escape_string($waktu_mulai);
				$waktu_selesai = $db->real_escape_string($waktu_selesai);
				$tempat = $db->real_escape_string($tempat);
				$keterangan = $db->real_escape_string($keterangan);

				edit_rangkaian_pengabdian($id_jadwal,$nama_acara,$tanggal,$waktu_mulai,$waktu_selesai,$tempat,$id_pengabdian,$keterangan);
			}
		}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sikado_Dosen</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="../../../assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="../../../assets/css/font-awesome.css" rel="stylesheet" />
    <!-- DROPDOWN STYLES-->
    <link href="../../../assets/css/dropdown.css" rel="stylesheet" />
	<!-- CUSTOM STYLES-->
    <link href="../../../assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	<link rel="shortcut icon" href="../../../login/assets/img/undip.png">
    <!-- TABLE STYLES-->
    <link href="../../../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />

	<script>
	function Konf1(z)
	{
		var result = confirm("Anda yakin ingin menghapus data ini?");
		if (result)
		{
			document.location = "delete_dosen.php?id="+z;
		}
	}
	</script>
	<style>
		.error{
			color: red;
		}
	</style>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <a class="navbar-brand" href="#"><img src="../../../assets/img/logo.png" height="50px"></a>
            </div>

			<!--dropdown punya rizka-->
			<div class="top-nav notification-row">
				<div class="nav pull-right top-menu">
					<li class="dropdown">
						<div class="dropdown-toggle" data-toggle="dropdown" href="#" style="color: white;
						padding: 10px 30px 5px 30px;
						float: right;
						font-size: 16px;">
							<span class="username">
								<?php echo $_SESSION['nama']; ?>
							</span>
							 <i style="color:white;" class="fa fa-caret-down"></i>
						</div>
						<ul class="dropdown-menu extended logout">
							<div class="log-arrow-up"></div>
							<li class="eborder-top">
								<a href="../../akun/view_profil_dosen.php"><i class="fa fa-user"></i>Profil</a>
							</li>
							<li>
								<a href="../../akun/ganti_password_dosen.php?id=<?php echo $id_user;?>"><i class="fa fa-pencil-square-o"></i>Ubah Password</a>
							</li>
							<li>
								<a href="../../../login/logout.php"><i class="fa fa-sign-out"></i> Log Out</a>
							</li>
						</ul>
					</li>
				</div>
			</div>
		</nav>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
					<li class="text-center">
						<?php
						include('../../db_login.php');
						$query = "SELECT * FROM dosen WHERE nip = '".$id_user."' ";
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
								if($row->foto==null)
								{
									echo '<img class="user-image img-responsive" src="../../akun/foto/find_user.png"width="123px" height="123px" alt="">';
								}
								else
								{
									echo '<img class="user-image img-responsive" src="../../akun/foto/'.$row->foto.'"width="123px" height="123px" alt="">';
								}
							}
						}
						?>
					</li>
					<li>
						<a  href="../../jadwal/view_jadwal.php"><i class="fa fa-table fa-3x"></i>Lihat Jadwal Harian</a>
					</li>
					<li>
						<a href="#"><i class="fa fa-sitemap fa-3x"></i> Kelola Kegiatan<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="../../pendidikan/view_pendidikan.php">Pendidikan</a>
							</li>
							<li>
								<a href="../../penelitian/view_penelitian.php">Penelitian</a>
							</li>
							<li>
								<a href="../view_pengabdian.php">Pengabdian</a>
							</li>
						</ul>
					</li>
                </ul>
            </div>
        </nav>
		<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>Edit Rangkaian Kegiatan Pengabdian <?php echo $nama_pengabdian;?></h2>
						<h5 class="error"> * wajib diisi </h5>
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />

				<!-- Page Content -->
				<div class="row">
					<div class="col-md-12">
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?id_jadwal='.$id_jadwal.'&id_pengabdian='.$id_pengabdian;?>" method="post" enctype="multipart/form-data"/>

								<div class="form-group">
								<label class="col-sm-2 col-sm-2 control-label"> Nama Acara </label>
								<div class="col-sm-8">
									<input type="text" name="nama_acara" class="form-control" size="30" maxlength="200" placeholder="" value="<?php if (isset($nama_acara)){echo $nama_acara;}?>">
									<span class="error">* <?php if (isset($error_nama_acara)){echo $error_nama_acara;}?></span>
								</div>
							</div>
							<div style="clear: both;" />


							<div class="form-group">
							<label class="col-sm-2 col-sm-2 control-label"> Tanggal </label>
							<div class="col-sm-3">
								<input type="date" name="tanggal" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($tanggal)){echo $tanggal;}?>">
								<span class="error">* <?php if (isset($error_tanggal)){echo $error_tanggal;}?></span>
							</div>
							</div>
							<div style="clear: both;" />

							<div class="form-group">
							<label class="col-sm-2 col-sm-2 control-label"> Waktu Mulai </label>
							<div class="col-sm-3">
								<input type="time" name="waktu_mulai" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($waktu_mulai)){echo $waktu_mulai;}?>">
								<span class="error">* <?php if (isset($error_waktu_mulai)){echo $error_waktu_mulai;}?></span>
							</div>
							</div>
							<div style="clear: both;" />


							<div class="form-group">
							<label class="col-sm-2 col-sm-2 control-label"> Waktu Selesai </label>
							<div class="col-sm-3">
								<input type="time" name="waktu_selesai" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($waktu_selesai)){echo $waktu_selesai;}?>">
								<span class="error">* <?php if (isset($error_waktu_selesai)){echo $error_waktu_selesai;}?></span>
							</div>
							</div>
							<div style="clear: both;" />

							<div class="form-group">
							<label class="col-sm-2 col-sm-2 control-label"> Tempat </label>
							<div class="col-sm-8">
								<input type="text" name="tempat" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($tempat)){echo $tempat;}?>"></td>
								<span class="error">* <?php if (isset($error_tempat)){echo $error_tempat;}?></span>
							</div>
							</div>
							<div style="clear: both;" />

							<div class="form-group">
							<label class="col-sm-2 col-sm-2 control-label">Keterangan </label></td>
							<div class="col-sm-8">
								<textarea rows="8" cols="90" name="keterangan" maxlength="1000"><?php if (isset($keterangan)){echo $keterangan;}?></textarea>
								<span class="error"><?php if (isset($error_keterangan)){echo $error_keterangan;}?></span>
							</div>
							</div>
							<div style="clear: both;" />
							<br/>

							<div class="form-group">
							<label class="col-sm-2 col-sm-2 control-label"></label>
								<div class="col-sm-10">
								<input type="submit" class="btn btn-outline btn-primary" name="submit" value="Simpan"/>
								<a href="view_rangkaian_pengabdian.php?id=<?php echo $id_pengabdian; ?>" class = "btn btn-outline btn-danger"><i class="fa fa-arrow-circle-left fa-fw"></i> Kembali </a>
								</div>
							</div>
						</form>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
		</div>
</body>
	<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="../../../assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="../../../assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="../../../assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="../../../assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="../../../assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
    <!-- CUSTOM SCRIPTS -->
    <script src="../../../assets/js/custom.js"></script>
</html>
<?php
	}
	else
	{
		echo '<script language="javascript">alert("Anda Belum Login, Silahkan Login terlebih dahulu"); document.location="../../../index.html";</script>';
	}
?>
