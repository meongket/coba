<?php
	require_once('../redirecter.php');
	require_once('../fungsiKadep.php');
	require_once('../db_login.php');
	//session_start();
	if (isset($_SESSION['username'])&& ($_SESSION['password']))
	{
		$id_user = $_SESSION['username'];
		$nip = $_GET['id'];
?>

<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<title>Kegiatan Dosen</title>
			<!-- BOOTSTRAP STYLES-->
			<link href="../../assets/css/bootstrap.css" rel="stylesheet" />
			<!-- FONTAWESOME STYLES-->
			<link href="../../assets/css/font-awesome.css" rel="stylesheet" />
			<!-- CUSTOM STYLES-->
			<link href="../../assets/css/custom.css" rel="stylesheet" />
			<!-- DROPDOWN STYLES-->
			<link href="../../assets/css/dropdown.css" rel="stylesheet" />
			<link rel="stylesheet" href="../../assets/css/style_tab_kadep.css">
			<!-- GOOGLE FONTS-->
			<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
			<link rel="shortcut icon" href="../../login/assets/img/undip.png"/>
		</head>

		<body>
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
		<!--logout biasa tanpa dropdown-->

		<!--dropdown punya rizka-->
		<div class="top-nav notification-row">
			<div class="nav pull-right top-menu">
				<li class="dropdown">
					<div class="dropdown-toggle" data-toggle="dropdown" href="#" style="color: white;
		padding: 10px 30px 5px 30px;
		float: right;
		font-size: 16px;">
						<span class="username">
							<?php echo $_SESSION['username']; ?>
						</span>
						 <i style="color:white;" class="fa fa-caret-down"></i>
					</div>
					<ul class="dropdown-menu extended logout">
						<div class="log-arrow-up"></div>
						<li>
							<a href="../akun/ganti_password_kadep.php"><i class="fa fa-pencil-square-o"></i>Ubah Password</a>
						</li>
						<li>
							<a href="../../login/logout.php"><i class="fa fa-sign-out"></i> Log Out</a>
						</li>
					</ul>
				</li>
			</div>
		</div>
	</nav>
			<main>
				<h2> Kegiatan Dosen  <?php view_nama_dosen($nip); ?></h2>
				<br/>
					<input id="tab1" type="radio" name="tabs" checked>
			    	<label for="tab1">Pendidikan</label>
			  	<input id="tab2" type="radio" name="tabs">
			    	<label for="tab2">Penelitian</label>
			  	<input id="tab3" type="radio" name="tabs">
			    	<label for="tab3">Pengabdian</label>

					<section id="content1">
					<br>
						<?php
							view_pendidikan($nip);
						?>
				  </section>
				  <section id="content2">
						<br>
						<?php
 						 view_penelitian($nip);
						?>
				  </section>
				  <section id="content3">
				    <br>
					<?php
 						 view_pengabdian($nip);
					?>
				  </section>
					<p><a class="btn btn-outline btn-danger" href= "../blank_kadep.php"><i class="fa fa-arrow-circle-left fa-fw"></i> Kembali</a></p>
				</main>
					<!-- /#page-wrapper -->
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
		echo '<script language="javascript">alert("Anda Belum Login, Silahkan Login terlebih dahulu"); document.location="../../login.html";</script>';
	}
?>
