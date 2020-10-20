<?php
	require_once('../redirecter.php');
	require_once('../fungsi_dosen.php');
	require_once('../db_login.php');
	//session_start();
	if (isset($_SESSION['username']) && ($_SESSION['password']))
	{
			$id = $_GET['id'];
			$cek = 1;

			if (!isset($_POST["submit"]))
			{
				$query = "SELECT * FROM dosen WHERE nip = '".$id."'";

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
						$nip = $row->nip;
						$nidn = $row->nidn;
						$gelar_depan = $row->gelar_depan;
						$nama = $row->nama;
						$gelar_belakang = $row->gelar_belakang;
						$email = $row->email;
						$tempat_lahir = $row->tempat_lahir;
						$tanggal_lahir= $row->tanggal_lahir;
						$alamat_rumah = $row->alamat_rumah;
						$no_hp = $row->no_hp;
						$scopus_id = $row->scopus_id;
					}
				}
			}
			else
			{
				$nip = test_input($id);
				if ($nip == "")
				{
					$error_nip = "NIP is required";
					$valid_nip = FALSE;
				}
				elseif (!preg_match("/^[0-9]*$/",$nip))
				{
					$error_nip = "NIP hanya berisi angka";
					$valid_nip = FALSE;
				}
				else
				{
					$valid_nip = TRUE;
				}

				$nidn = test_input($_POST['nidn']);
				if ($nidn == "")
				{
					$error_nidn = "NIDN is required";
					$valid_nidn = FALSE;
				}
				elseif (!preg_match("/^[0-9]*$/",$nidn))
				{
					$error_nidn = "NIDN hanya berisi angka";
					$valid_nidn = FALSE;
				}
				else
				{
					$valid_nidn = TRUE;
				}

				$gelar_depan = test_input($_POST['gelar_depan']);
				if (!preg_match("/^[a-zA-Z,. ]*$/",$gelar_depan))
				{
					$error_gelar_depan = "hanya huruf, tanda '.', tanda ',' dan spasi yang dibolehkan";
					$valid_gelar_depan = FALSE;
				}
				else
				{
					$valid_gelar_depan = TRUE;
				}

				$nama = test_input($_POST['nama']);
				if ($nama == "")
				{
					$error_nama = "Nama is required";
					$valid_nama = FALSE;
				}
				elseif (!preg_match("/^[a-zA-Z ]*$/",$nama))
				{
					$error_nama = "Hanya huruf dan spasi yang dibolehkan";
					$valid_nama = FALSE;
				}
				else
				{
					$valid_nama = TRUE;
				}

				$gelar_belakang = test_input($_POST['gelar_belakang']);
				if (!preg_match("/^[a-zA-Z,. ]*$/",$gelar_belakang))
				{
					$error_gelar_belakang = "hanya huruf, tanda '.', tanda ',' dan spasi yang dibolehkan";
					$valid_gelar_belakang = FALSE;
				}
				else
				{
					$valid_gelar_belakang = TRUE;
				}

				$email = test_input($_POST['email']);
				if ($email == "")
				{
					$error_email = "Email is required";
					$valid_email = FALSE;
				}
				elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					$error_email = "hanya huruf, tanda '.', tanda ',' dan spasi yang dibolehkan";
					$valid_email = FALSE;
				}
				else
				{
					$valid_email = TRUE;
				}

				$tempat_lahir = test_input($_POST['tempat_lahir']);
				if ($tempat_lahir == "")
				{
					$error_tempat_lahir = "Tempat lahir is required";
					$valid_tempat_lahir = FALSE;
				}
				elseif (!preg_match("/^[a-zA-Z,. ]*$/",$tempat_lahir))
				{
					$error_tempat_lahir = "hanya huruf, tanda '.', tanda ',' dan spasi yang dibolehkan";
					$valid_tempat_lahir = FALSE;
				}
				else
				{
					$valid_tempat_lahir = TRUE;
				}

				$tanggal_lahir = test_input($_POST['tanggal_lahir']);
				if ($tanggal_lahir == "")
				{
					$error_tanggal_lahir = "Tanggal lahir is required";
					$valid_tanggal_lahir = FALSE;
				}
				else
				{
					$valid_tanggal_lahir = TRUE;
				}

				$alamat_rumah = test_input($_POST['alamat_rumah']);
				if ($alamat_rumah == "")
				{
					$error_alamat_rumah = "Alamat rumah is required";
					$valid_alamat_rumah = FALSE;
				}
				else
				{
					$valid_alamat_rumah = TRUE;
				}

				$no_hp = test_input($_POST['no_hp']);
				if ($no_hp == "")
				{
					$error_no_hp = "Nomor HP is required";
					$valid_no_hp = FALSE;
				}
				elseif (!preg_match("/^[0-9+ ]*$/",$no_hp))
				{
					$error_no_hp = "hanya angka dan tanda '+' yang dibolehkan";
					$valid_no_hp = FALSE;
				}
				else
				{
					$valid_no_hp = TRUE;
				}

				$scopus_id = test_input($_POST['scopus_id']);

				//--------------------------UNTUK UPLOAD GAMBAR------------------------------------------------
			  //Folder tujuan upload file
			  $folder		= './foto/';
			  //type file yang bisa diupload
			  $file_type	= array('jpg','jpeg','png');
			  //tukuran maximum file yang dapat diupload
			  $max_size	= 2000000; // 2MB


			  //Mulai memorises data
			  $file_name	= $_FILES['foto']['name'];
			  $file_size	= $_FILES['foto']['size'];
			  //cari extensi file dengan menggunakan fungsi explode
			  $explode	= explode('.',$file_name);
			  $extensi	= $explode[count($explode)-1];

			  //untuk penamaan file baru
					$file_name = $id.".".$extensi;

			  //mulai pengecekan form
			  $foto = $_FILES['foto']['name'];
			  if($foto == "" || $foto =="none")
			  {
				$cek = 0;
				$valid_foto = TRUE;
			  }

			  if ($cek == 1)
			  {
				if(!in_array($extensi,$file_type)) //check apakah type file sudah sesuai
				{
				  $error_foto = "Ekstensi yang Anda masukkan tidak sesuai";
				  $valid_foto = FALSE;
				}
				else if($file_size > $max_size) //check ukuran file apakah sudah sesuai
				{
				  $error_foto = "Ukuran file tidak boleh melebihi 5 MB";
				  $valid_foto = FALSE;
				}
				else
				{
				  $valid_foto = TRUE;
				}
			  }
			//--------------------------------------------------------------------------------------


				if ($valid_nip && $valid_nidn && $valid_nama && $valid_tempat_lahir && $valid_tanggal_lahir && $valid_alamat_rumah && $valid_no_hp && $valid_foto)
				{
					$nip = $db->real_escape_string($nip);
					$nidn = $db->real_escape_string($nidn);
					$gelar_depan = $db->real_escape_string($gelar_depan);
					$nama = $db->real_escape_string($nama);
					$gelar_belakang = $db->real_escape_string($gelar_belakang);
					$tempat_lahir = $db->real_escape_string($tempat_lahir);
					$tanggal_lahir = $db->real_escape_string($tanggal_lahir);
					$alamat_rumah = $db->real_escape_string($alamat_rumah);
					$no_hp = $db->real_escape_string($no_hp);
					$scopus_id = $db->real_escape_string($scopus_id);

					//----------------------------TAMBAH GAMBAR KE DATABASE------------------------------
			if ($cek == 1)
			{
			  if (move_uploaded_file($_FILES['foto']['tmp_name'], $folder.$file_name))
			  {
				//mencatat file ke database
				$query = "UPDATE dosen SET foto = '".$file_name."' WHERE nip = ".$nip." ";
				// Execute the query
				$result = $db->query($query);
				if (!$result)
				{
				  die ("Could not query the database: <br />". $db->error);
				}
			  }
			  else
			  {
				  echo '<script language="javascript">alert("Proses upload eror!"); document.location="edit_profil_dosen.php?id='.$nip.' ";</script>';
			  }
			}
			//---------------------------------------------------------------------------------

					//mengupdate file lain
					edit_profil_dosen($nip,$nidn,$gelar_depan,$nama,$gelar_belakang,$email,$tempat_lahir,$tanggal_lahir,$alamat_rumah,$no_hp,$scopus_id);
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
			<link href="../../assets/css/bootstrap.css" rel="stylesheet" />
			 <!-- FONTAWESOME STYLES-->
			<link href="../../assets/css/font-awesome.css" rel="stylesheet" />
			<!-- CUSTOM STYLES-->
			<link href="../../assets/css/custom.css" rel="stylesheet" />
			<!-- DROPDOWN STYLES-->
			<link href="../../assets/css/dropdown.css" rel="stylesheet" />
			 <!-- STYLES LOGOUT -->
			<link href="../../assets/style.css" rel="stylesheet" />
			<!-- TABLE STYLES-->
			<link href="../../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
			<!-- GOOGLE FONTS-->
			<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
			<link rel="shortcut icon" href="../../login/assets/img/undip.png"/>
			<script>
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
					<a class="navbar-brand" href="#"><img src="../../login/assets/img/logo.png" height="50px"></a>
				</div>
				<!--logout biasa tanpa dropdown-->

				<!--dropdown logout-->
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
									<a href="view_profil_dosen.php"><i class="fa fa-user"></i>Profil</a>
								</li>
								<li>
									<a href="ganti_password_dosen.php?id=<?php echo $id;?> "><i class="fa fa-pencil-square-o"></i>Ubah Password</a>
								</li>
								<li>
									<a href="../../login/logout.php"><i class="fa fa-sign-out"></i> Log Out</a>
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
							<?php view_foto($id);?>
						</li>
						<li>
							<a  href="../blank_dosen.php"><i class="fa fa-table fa-3x"></i>Lihat Jadwal Harian</a>
						</li>
						<li>
							<a href="#"><i class="fa fa-sitemap fa-3x"></i> Kelola Kegiatan<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="../pendidikan/view_pendidikan.php">Pendidikan</a>
								</li>
								<li>
									<a href="../penelitian/view_penelitian.php">Penelitian</a>
								</li>
								<li>
									<a href="../pengabdian/view_pengabdian.php">Pengabdian</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- /. NAV SIDE  -->
			<div id="page-wrapper" >
				<div id="page-inner">
					<div class="row">
						<div class="col-md-12">
						<h2>Edit Profil Dosen</h2>
						<h5 class="error"> * wajib diisi </h5>
						</div>
					</div>
					<!-- /. ROW  -->
					 <hr />

			 <!-- /. WRAPPER  -->
				<!-- Page Content -->
					<div class="row">
						<div class="col-md-12">
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?id='.$id;?>" method="post" enctype="multipart/form-data"/>

								<div class="form-group">
								<label class="col-sm-2 col-sm-2 control-label"> Foto </label>
								<div class="col-sm-4">
									<input type="file" name="foto">
									<span class="error">*<?php if (isset($error_foto)){echo $error_foto;}?></span>
								</div>
								</div>
								<div style="clear: both;" />

								<div class="form-group">
									<label class="col-sm-2 col-sm-2"> NIP </label>
									<div class="col-sm-4">
										<input type="text" name="nip" class="form-control" size="30" maxlength="14" placeholder="" disabled value="<?php if (isset($nip)){echo $nip;}?>"></td>
										<span class="error">* <?php if (isset($error_nip)){echo $error_nip;}?></span>
									</div>
								</div>
								<div style="clear: both;" /></div>

								<div class="form-group">
									<label class="col-sm-2 col-sm-2"> NIDN </label>
									<div class="col-sm-4">
										<input type="text" name="nidn" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($nidn)){echo $nidn;}?>">
										<span class="error">* <?php if (isset($error_nidn)){echo $error_nidn;}?></span>
									</div>
								</div>
								<div style="clear: both;" /></div>

								<div class="form-group">
									<label class="col-sm-2 col-sm-2"> Gelar Depan </label>
									<div class="col-sm-4">
										<input type="text" name="gelar_depan" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($gelar_depan)){echo $gelar_depan;}?>">
									</div>
								</div>
								<div style="clear: both;" /></div>

								<div class="form-group">
									<label class="col-sm-2 col-sm-2"></label>
									<div class="col-sm-3">

									</div>
								</div>
								<div style="clear: both;" /></div>

								<div class="form-group">
									<label class="col-sm-2 col-sm-2"> Nama </label>
									<div class="col-sm-4">
										<input type="text" name="nama" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($nama)){echo $nama;}?>">
										<span class="error">* <?php if (isset($error_nama)){echo $error_nama;}?></span>
									</div>
								</div>
								<div style="clear: both;" /></div>

								<div class="form-group">
									<label class="col-sm-2 col-sm-2"> Gelar Belakang </label>
									<div class="col-sm-4">
										<input type="text" name="gelar_belakang" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($gelar_belakang)){echo $gelar_belakang;}?>">
									</div>
								</div>
								<div style="clear: both;" /></div>

								<div class="form-group">
									<label class="col-sm-2 col-sm-2"></label>
									<div class="col-sm-3">

									</div>
								</div>
								<div style="clear: both;" /></div>

								<div class="form-group">
									<label class="col-sm-2 col-sm-2"> Email </label>
									<div class="col-sm-4">
										<input type="text" name="email" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($email)){echo $email;}?>"></td>
										<span class="error">* <?php if (isset($error_email)){echo $error_email;}?></span>
									</div>
								</div>
								<div style="clear: both;" /></div>

								<div class="form-group">
									<label class="col-sm-2 col-sm-2"> Tempat Lahir </label>
									<div class="col-sm-4">
										<input type="text" name="tempat_lahir" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($tempat_lahir)){echo $tempat_lahir;}?>">
										<span class="error">* <?php if (isset($error_tempat_lahir)){echo $error_tempat_lahir;}?></span>
									</div>
								</div>
								<div style="clear: both;" /></div>

								<div class="form-group">
									<label class="col-sm-2 col-sm-2"> Tanggal Lahir </label>
									<div class="col-xs-6 col-sm-3">
										<input type="date" name="tanggal_lahir" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($tanggal_lahir)){echo $tanggal_lahir;}?>">
										<span class="error">* <?php if (isset($error_tanggal_lahir)){echo $error_tanggal_lahir;}?></span>
									</div>
								</div>
								<div style="clear: both;" /></div>

								<div class="form-group">
									<label class="col-sm-2 col-sm-2"> Alamat Rumah </label>
									<div class="col-sm-4">
										<textarea rows="5" cols="40" name="alamat_rumah" maxlength="1000"><?php if (isset($alamat_rumah)){echo $alamat_rumah;}?></textarea>
										<span class="error">* <?php if (isset($error_alamat_rumah)){echo $error_alamat_rumah;}?></span>
									</div>
								</div>
								<div style="clear: both;" /></div>

								<div class="form-group">
									<label class="col-sm-2 col-sm-2"> Nomor HP / Telepon </label>
									<div class="col-sm-4">
										<input type="text" name="no_hp" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($no_hp)){echo $no_hp;}?>"></td>
										<span class="error">* <?php if (isset($error_no_hp)){echo $error_no_hp;}?></span>
									</div>
								</div>
								<div style="clear: both;" /></div>

								<div class="form-group">
									<label class="col-sm-2 col-sm-2"> Scopus ID </label>
									<div class="col-sm-4">
										<input type="text" name="scopus_id" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($scopus_id)){echo $scopus_id;}?>">
									</div>
								</div>
								<div style="clear: both;" /></div>

								<br/>
								<div class="form-group">
									<label class="col-sm-2 col-sm-2"></label>
									<div class="col-sm-4">
										<input type="submit" class="btn btn-outline btn-primary" name="submit" value="Simpan"/>
										<span> <a href = "view_profil_dosen.php" class="btn btn-danger"><i class="fa fa-arrow-circle-left fa-fw"></i> Kembali </a></span>
									</div>
								</div>
								<div style="clear: both;" /></div>
						</div>
					</form>
					<!--<div class="col-md-12">
						<input type="submit" class="btn btn-outline btn-primary" name="submit" value="Submit"/>
						<a href = "view_profil_dosen.php" class="btn btn-danger">Kembali </a>
					</div>-->
				</div>
			<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
			</div>
		<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
		</div>
		<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
		<!-- JQUERY SCRIPTS -->
		<script src="../../assets/js/jquery-1.10.2.js"></script>
		  <!-- BOOTSTRAP SCRIPTS -->
		<script src="../../assets/js/bootstrap.min.js"></script>
		<!-- METISMENU SCRIPTS -->
		<script src="../../assets/js/jquery.metisMenu.js"></script>
		  <!-- CUSTOM SCRIPTS -->
		<script src="../../assets/js/custom.js"></script>
		<!-- DATA TABLE SCRIPTS -->
		<script src="../../assets/js/dataTables/jquery.dataTables.js"></script>
		<script src="../../assets/js/dataTables/dataTables.bootstrap.js"></script>
			<script>
				$(document).ready(function () {
					$('#dataTables-example').dataTable();
				});
		</script>
		</body>

		</html>
<?php		
	}
	else
	{
		echo '<script language="javascript">alert("Anda Belum Login, Silahkan Login terlebih dahulu"); document.location="../../index.html";</script>';
	}
?>
