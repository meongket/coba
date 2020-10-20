<?php
	require_once	('../redirecter.php');
	require_once('../fungsi_dosen.php');
	require_once('../../login/db_login.php');
	//session_start();
	if (isset($_SESSION['username']) && ($_SESSION['password']))
	{
		$id = $_GET['id'];
		$id_user=$_SESSION['username'];
		$cek = 0;
		if (!isset($_POST["submit"]))
		{
			$query = "SELECT * FROM penelitian WHERE id_penelitian = '".$id."' ";
			$result = $db->query($query);
			if (!$result)
			{
				die ("Could not query the database: <br />". $db->error);
			}
			else
			{
				while ($row = $result->fetch_object())
				{
					$judul = $row->judul;
					$skim = $row->skim;
					$tgl_mulai = $row->tgl_mulai;
					$tgl_selesai = $row->tgl_selesai;
					$sumber_dana = $row->sumber_dana;
					$output = $row->output;
				}
			}
		}
		else
		{
			$nip = test_input($_SESSION['username']);
			$judul = test_input($_POST['judul']);
			if ($judul == "" || $judul == "none")
			{
				$error_judul = "judul is required";
				$valid_judul = FALSE;
			}
			else
			{
				$valid_judul = TRUE;
			}

			$skim = test_input($_POST['skim']);
			if ($skim == "" || $judul =="none")
			{
				$error_skim = "SKIM is required";
				$valid_skim = FALSE;
			}
			else
			{
				$valid_skim = TRUE;
			}

			$tgl_mulai = test_input($_POST['tgl_mulai']);
			if ($tgl_mulai == "")
			{
				$error_tgl_mulai = "Mulai Pelaksanaan is required";
				$valid_tgl_mulai = FALSE;
			}
			else
			{
				$valid_tgl_mulai = TRUE;
			}

			$tgl_selesai = test_input($_POST['tgl_selesai']);
			if ($tgl_selesai == "")
			{
				$error_tgl_selesai = "Selesai Pelaksanaan is required";
				$valid_tgl_selesai = FALSE;
			}
			else
			{
				$valid_tgl_selesai = TRUE;
			}

			$sumber_dana = test_input($_POST['sumber_dana']);
			if ($sumber_dana == "")
			{
				$error_sumber_dana = "Sumber Dana is required";
				$valid_sumber_dana = FALSE;
			}
			else
			{
				$valid_sumber_dana = TRUE;
			}

			$output = $_FILES['output']['name'];
		//--------------------------UNTUK UPLOAD------------------------------------------------
			if($output == "" || $output =="none")
			{
				$valid_output = true;
			}
			else
			{
				$cek = 1;
				//Folder tujuan upload file
				$folder		= './file_upload/';
				//type file yang bisa diupload
				$file_type	= array('jpg','jpeg','png','gif','bmp','doc','docx','xls','xlsx','sql','pdf');
				//tukuran maximum file yang dapat diupload
				$max_size	= 5000000; // 5MB

				//Mulai memorises data
				$file_name	= $_FILES['output']['name'];
				$file_size	= $_FILES['output']['size'];
				//cari extensi file dengan menggunakan fungsi explode
				$explode	= explode('.',$file_name);
				$extensi	= $explode[count($explode)-1];

				if(!in_array($extensi,$file_type)) //check apakah type file sudah sesuai
				{
					$error_output = "Ekstensi yang anda masukkan tidak sesuai";
					$valid_output = false;
				}
				else if($file_size > $max_size) //check ukuran file apakah sudah sesuai
				{
					$error_output = "Ukuran file tidak boleh melebihi 5 MB";
					$valid_output = false;
				}
				else {
					$valid_output = true;
				}
			}
		//--------------------------------------------------------------------------------------

			if ($valid_judul && $valid_skim && $valid_tgl_mulai && $valid_tgl_selesai && $valid_sumber_dana && $valid_output)
			{
				$id_penelitian = $id;
				$judul = $db->real_escape_string($judul);
				$skim = $db->real_escape_string($skim);
				$tgl_mulai = $db->real_escape_string($tgl_mulai);
				$tgl_selesai = $db->real_escape_string($tgl_selesai);
				$sumber_dana = $db->real_escape_string($sumber_dana);

			//--------------------------UNTUK UPLOAD------------------------------------------------
				if ($cek == 1){
					//mulai memproses upload file
					if (move_uploaded_file($_FILES['output']['tmp_name'], $folder.$file_name))
					{
						//mencatat nama file ke database
						$query ="UPDATE penelitian SET output = '".$file_name."', folder = '".$folder."'
												 WHERE id_penelitian = '".$id."' ";
						$result=$db->query($query);
						if (!$result)
						{
							die ("Could not query the database: <br />". $db->error);
						}
					}
					else
					{
								echo '<script language="javascript">alert("Proses upload eror!"); document.location="#";</script>';
					}
				}
			//--------------------------SELESAI UPLOAD------------------------------------------------

			edit_penelitian($id,$judul,$skim,$tgl_mulai,$tgl_selesai,$sumber_dana);
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
    <!-- DROPDOWN STYLES-->
    <link href="../../assets/css/dropdown.css" rel="stylesheet" />
	<!-- CUSTOM STYLES-->
    <link href="../../assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	<link rel="shortcut icon" href="../../login/assets/img/undip.png">
    <!-- TABLE STYLES-->
    <link href="../../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
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
               <a class="navbar-brand" href="#"><img src="../../assets/img/logo.png" height="50px"></a>
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
								<a href="../akun/view_profil_dosen.php"><i class="fa fa-user"></i>Profil</a>
							</li>
							<li>
								<a href="../akun/ganti_password_dosen.php?id=<?php echo $id_user;?>"><i class="fa fa-pencil-square-o"></i>Ubah Password</a>
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
						<?php
						include('../db_login.php');
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
									echo '<img class="user-image img-responsive" src="../akun/foto/find_user.png"width="123px" height="123px" alt="">';
								}
								else
								{
									echo '<img class="user-image img-responsive" src="../akun/foto/'.$row->foto.'"width="123px" height="123px" alt="">';
								}
							}
						}
						?>
					</li>
					<li>
						<a  href="../jadwal/view_jadwal.php"><i class="fa fa-table fa-3x"></i>Lihat Jadwal Harian</a>
					</li>
					<li>
						<a href="#"><i class="fa fa-sitemap fa-3x"></i> Kelola Kegiatan<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="../pendidikan/view_pendidikan.php">Pendidikan</a>
							</li>
							<li>
								<a class="active-menu" href="../penelitian/view_penelitian.php">Penelitian</a>
							</li>
							<li>
								<a href="../pengabdian/view_pengabdian.php">Pengabdian</a>
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
                     <h2>Edit Data Penelitian</h2>
                       <h5 class="error"> * wajib diisi </h5>
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />

			<div class="row">
				<div class="col-md-12">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?id='.$id;?>" method="post" enctype="multipart/form-data">

						<div class="form-group">
							<label class="col-sm-2 col-sm-2 control-label"> Judul Penelitian </label>
							<div class="col-sm-8">
								<input type="text" name="judul" class="form-control" size="30" maxlength="200" placeholder="" value="<?php if (isset($judul)){echo $judul;}?>"></td>
								<span class="error">* <?php if (isset($error_judul)){echo $error_judul;}?></span>
							</div>
							</div>
							<div style="clear: both;" />

							<div class="form-group">
							<label class="col-sm-2 col-sm-2 control-label"> SKIM </label>
							<div class="col-sm-8">
								<input type="text" name="skim" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($skim)){echo $skim;}?>">
								<span class="error">* <?php if (isset($error_skim)){echo $error_skim;}?></span>
							</div>
							</div>
							<div style="clear: both;" />

							<div class="form-group">
							<label class="col-sm-2 col-sm-2 control-label"> Tanggal Mulai </label>
							<div class="col-sm-3">
								<input type="date" name="tgl_mulai" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($tgl_mulai)){echo $tgl_mulai;}?>"></td>
								<span class="error">* <?php if (isset($error_tgl_mulai)){echo $error_tgl_mulai;}?></span>
							</div>
							</div>
							<div style="clear: both;" />

							<div class="form-group">
							<label class="col-sm-2 col-sm-2 control-label"> Tanggal Selesai </label>
							<div class="col-sm-3">
								<input type="date" name="tgl_selesai" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($tgl_selesai)){echo $tgl_selesai;}?>"></td>
								<span class="error">* <?php if (isset($error_tgl_selesai)){echo $error_tgl_selesai;}?></span>
							</div>
							</div>
							<div style="clear: both;" />

							<div class="form-group">
							<label class="col-sm-2 col-sm-2 control-label">  Sumber dana </label>
							<div class="col-sm-3">
								<input type="text" name="sumber_dana" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($sumber_dana)){echo $sumber_dana;}?>"></td>
								<span class="error">* <?php if (isset($error_sumber_dana)){echo $error_sumber_dana;}?></span>
							</div>
							</div>
							<div style="clear: both;" />

							<div class="form-group">
							<label class="col-sm-2 col-sm-2 control-label">Output </label>
							<div class="col-sm-3">
								<input type="file" name="output" value="<?php if (isset($output)){echo $output;}?>"></td>
								<span class="error"> <?php if (isset($error_output)){echo $error_output;}?></span>
							</div>
							</div>
							<div style="clear: both;" />

								<br>
							<div class="form-group">
							<label class="col-sm-2 col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<input type="submit" class="btn btn-outline btn-primary" name="submit" value="Simpan"/>
									<a href = "view_penelitian.php" class="btn btn-danger"><i class="fa fa-arrow-circle-left fa-fw"></i> Kembali </a></td></span>
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
    <script src="../../assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="../../assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="../../assets/js/jquery.metisMenu.js"></script>
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
	</html>
<?php
	}
	else
	{
		echo '<script language="javascript">alert("Anda Belum Login, Silahkan Login terlebih dahulu"); document.location="../../index.html";</script>';
	}
?>
