<?php
	require_once	('../redirecter.php');
	require_once('../fungsi_dosen.php');
	require_once('../../login/db_login.php');
	//session_start();
	if (isset($_SESSION['username'])&& ($_SESSION['password']))
	{
		$id = $_SESSION['username'];
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
								<a href="../akun/ganti_password_dosen.php?id=<?php echo $id;?>"><i class="fa fa-pencil-square-o"></i>Ubah Password</a>
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
								<a href="../penelitian/view_penelitian.php">Penelitian</a>
							</li>
							<li>
								<a class="active-menu" href="#">Pengabdian</a>
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
                     <h2>Daftar Data Pengabdian</h2>

                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
				<!-- Page Content -->
				<a href="add_pengabdian.php" class = "btn btn-outline btn-default" style="float: left"><i class="fa fa-plus fa-fw"></i> Tambah Pengabdian</a>
				<br></br><br></br>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Data Pengabdian
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
											<th> No </th>
											<th> Judul </th>
											<th> Skim </th>
											<th> Tanggal Mulai </th>
											<th> Tanggal Selesai </th>
											<th> Sumber Dana </th>
											<th> Aksi </th>
										</tr>
                                    </thead>
									<?php view_pengabdian($id);?>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
                <!-- /. ROW  -->
        </div>

    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
     <!-- /. WRAPPER  -->
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

		</body>

		</html>
<?php
	}
	else
	{
		echo '<script language="javascript">alert("Anda Belum Login, Silahkan Login terlebih dahulu"); document.location="../../index.html";</script>';
	}
?>
