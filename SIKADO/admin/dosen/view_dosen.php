<?php
	require_once('../fungsiAdmin.php');
	require_once('../db_login.php');
	session_start();
	if (isset($_SESSION['username'])&& ($_SESSION['password']))
	{
		require_once('../db_login.php');
		$id = $_SESSION['username'];

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sikado_Admin</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="../../assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="../../assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="../../assets/css/custom.css" rel="stylesheet" />
	<link href="../../assets/css/dropdown.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   <!-- table template-->
   <link href="../../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
   <link rel="shortcut icon" href="../../login/assets/img/undip.png">
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
                <a class="navbar-brand" href="#"><img src="../../login/assets/img/logo.png" height="50px"></a> 
            </div>
			<div class="top-nav notification-row">
				<div class="nav pull-right top-menu">
					<li class="dropdown">
						<div class="dropdown-toggle" data-toggle="dropdown" href="#" style="color: white;
								padding: 10px 30px 5px 30px; float: right; font-size: 16px;">
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
                                <a class="active-menu" href="#">Dosen</a>
                            </li>
                            <li>
                                <a href="../kadep/view_kadep.php">Ketua Departemen</a>
                            </li>
                            <li>
                                <a href="../mahasiswa/view_mahasiswa.php">Mahasiswa</a>  
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
                     <h2>Daftar Dosen Departemen Statistika</h2>   
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
				 <a href="add_dosen.php" class = "btn btn-outline btn-default" style="margin-left:0px; margin-top: -50px; margin-bottom: -40px"><i class="fa fa-plus fa-fw"></i> Tambah Dosen</a></p>
				 <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Daftar Dosen
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
											<th> No </th>
											<th> NIP </th>
											<th> NIDN </th>
											<th> Nama </th>
											<th> Aksi </th>
										</tr>
                                    </thead>                                    
									<?php
									// Include our login information
									//Asign a query
									view_dosen();
									?>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>

               
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
		</div>
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
		echo '<script language="javascript">alert("Anda Belum Login, Silahkan Login terlebih dahulu"); document.location="../login.html";</script>';
	}
?>		
