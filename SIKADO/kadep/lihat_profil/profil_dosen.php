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
			<title>Profil Dosen</title>
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
							<a class="navbar-brand" href="#"><img src="../../login/assets/img/logo.png" height="50px"></a>
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
		<div class="page-inner">
            <h2 class="page-header">
              Profil Dosen
            </h2>
            <div class="row">
              <div class="col-md-5">
                <div class="thumbnail">
			<?php 
						include('../db_login.php');
						$query = "SELECT * FROM dosen WHERE nip = '".$nip."' ";
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
									echo '<img class="img-responsive" style="border:0" src="../../dosen/akun/foto/find_user.png"width="300px" height="300px" alt="">';
								}
								else
								{
									echo '<img class="img-responsive" src="../../dosen/akun/foto/'.$row->foto.'" width="300px" height="300px" width="300px" height="300px"  alt="">';
								}
							}
						}
						echo '</div>';
						echo '</div>';
						echo '<div class="col-md-6">';
						echo '<div class="panel panel-primary">';
						echo '<div class="panel-heading">';
						echo '</div>';
						echo '<div class="panel-body">';
						echo '<br>';
						echo '<div class="table-responsive">';
				// Include our login information
				//Asign a query
				view_profil_dosen($nip);
			?>
			  </div><!--end of tabel responsif-->
                </div><!--end of panel content-->
              </div><!--end of panel-->
			</div>
		</div>
		</div>
		<br/>
		<div class="pull-right">
			<a class="btn btn-outline btn-danger" href= "../blank_kadep.php"><i class="fa fa-arrow-circle-left fa-fw"></i> Kembali</a>
		</div>
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
		echo '<script language="javascript">alert("Anda Belum Login, Silahkan Login terlebih dahulu"); document.location="../../index.html";</script>';
	}
?>
