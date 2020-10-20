<?php
	require_once('../fungsiAdmin.php');
	require_once('../db_login.php');
	
	session_start();
	if (isset($_SESSION['username']) && ($_SESSION['password']))
	{	
		$id = $_SESSION['username'];
		if (isset($_POST["submit"]))
		{
			$nim = test_input($_POST['NIM']);
			if ($nim == "" || $nim == "none")
			{
				$error_nim = "NIM is required";
				$valid_nim = FALSE;
			}
			elseif (!preg_match("/^[0-9]*$/",$nim)) 
			{
				$error_nim = "NIM hanya berisi angka";
				$valid_nim = FALSE;
			}
			else
			{
				$valid_nim = TRUE;
			}
			
			$nama = test_input($_POST['nama']);
			if ($nama == "" || $nama == "none")
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
			
			if ($valid_nim && $valid_nama)
			{
				$query = "SELECT nim FROM mahasiswa";
				$result = $db->query($query);
				if (!$result)
				{
					 die ("Could not query the database: <br />". $db->error);
				}
				else
				{
					$data_ulang = 0;
					while ($row = $result->fetch_object())
					{
						$nim_db = $row->nim;
						if ($nim_db == $nim)
						{
							$data_ulang = 1;		
						}
					}
					if ($data_ulang == 1)
					{
						echo '<script language="javascript">alert("Data dengan nim '.$nim.' telah terdaftar"); document.location="add_mahasiswa.php";</script>';
						$db->close();
						exit;
					}
					else
					{
						$nim = $db->real_escape_string($nim);
						$nama = $db->real_escape_string($nama);
						$password = $db->real_escape_string($nim);
						//$password_enkrip = md5(md5($password));
						
						add_mahasiswa($nim,$nama,$password);
					}
				}
			}
		}	
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Mahasiswa</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="../../assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="../../assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="../../assets/css/custom.css" rel="stylesheet" />
	<link href="../../assets/css/dropdown.css" rel="stylesheet" />
	
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   <link rel="shortcut icon" href="../../login/assets/img/undip.png">
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
    <div class="top-nav notification-row">
				<div class="nav pull-right top-menu">
					<li class="dropdown">
						<div class="dropdown-toggle" data-toggle="dropdown" href="#" style="color: white; padding: 10px 30px 5px 30px; float: right; font-size: 16px;">
							<span class="username">
								<?php echo $_SESSION['username']; ?>
							</span>
							 <i style="color:white;" class="fa fa-caret-down"></i>
						</div>
						<ul class="dropdown-menu extended logout">
							<div class="log-arrow-up"></div>
							<li class="eborder-top">
								<a href="../admin/ganti_password_admin.php?id=<?php echo $id;?>"><i class="fa fa-pencil-square-o"></i>Ubah Password</a>
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
						<img src="../../assets/img/find_user.png" class="user-image img-responsive"/>
					</li>
					                   
					<li>
						<a href="#"><i class="fa fa-sitemap fa-3x"></i> Kelola Akun <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="../dosen/view_dosen.php">Dosen</a>
								</li>
								<li>
									<a href="../kadep/view_kadep.php">Ketua Departemen</a>
								</li>
								<li>
									<a class="active-menu" href="view_mahasiswa.php">Mahasiswa</a>  
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
					<h2>Tambah Mahasiswa</h2>
					<h5 class="error"> * wajib diisi </h5> 
					</div>
                </div>
				<!-- /. ROW  -->
                 <hr />
				<!-- Page Content -->
				<div class="row">
					<div class="col-md-12">
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data"/>
								<div class="form-group">
									<label class="col-sm-3 col-sm-3"> Masukkan NIM </label>
									<div class="col-sm-3">
										<input type="text" name="NIM" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($nim)){echo $nim;}?>">
										<span class="error">* <?php if (isset($error_nim)){echo $error_nim;}?></span>
									</div>
								</div>
								<div style="clear: both;" /></div>
								<div class="form-group">
									<label class="col-sm-3 col-sm-3"> Masukkan Nama </label>
									<div class="col-sm-3">
										<input type="text" name="nama" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($nama)){echo $nama;}?>">
										<span class="error">* <?php if (isset($error_nama)){echo $error_nama;}?></span>	
									</div>
								</div>
								<div style="clear: both;" /></div>
								
								<br/>
								<div class="form-group">
								<label class="col-sm-3 col-sm-3"></label>
									<div class="col-sm-3">
										<input type="submit" class="btn btn-outline btn-primary" name="submit" id="submit" value="Simpan"/>
									</div>
								</div>
							</div>
						</form>
					</div>
		    <script src="../../assets/js/jquery-1.10.2.js"></script>
			<!-- BOOTSTRAP SCRIPTS -->
			<script src="../../assets/js/bootstrap.min.js"></script>
			<!-- METISMENU SCRIPTS -->
			<script src="../../assets/js/jquery.metisMenu.js"></script>
			<!-- CUSTOM SCRIPTS -->
			<script src="../../assets/js/custom.js"></script>						
		</body>
	</html>
<?php
	}
	else
	{
		echo '<script language="javascript">alert("Anda Belum Login, Silahkan Login terlebih dahulu"); document.location="../login.html";</script>';
	}
?>
