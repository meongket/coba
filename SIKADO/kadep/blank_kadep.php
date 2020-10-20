<?php
	require_once('redirecter.php');
	require_once('fungsiKadep.php');
	require_once('db_login.php');
	//session_start();
	if (isset($_SESSION['username'])&& ($_SESSION['password']))
	{
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ketua Departemen</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <!-- DROPDOWN STYLES-->
    <link href="../assets/css/dropdown.css" rel="stylesheet" />
	<link rel="stylesheet" href="../assets/css/style_tab.css">
	<!-- CUSTOM STYLES-->
    <link href="../assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	<link rel="shortcut icon" href="../../login/assets/img/undip.png"/>
    <!-- TABLE STYLES-->
    <link href="../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
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
               <a class="navbar-brand" href="#"><img src="../assets/img/logo.png" height="50px"></a>
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
								<?php echo $_SESSION['username']; ?>
							</span>
							 <i style="color:white;" class="fa fa-caret-down"></i>
						</div>
						<ul class="dropdown-menu extended logout">
							<div class="log-arrow-up"></div>
							<li>
								<a href="akun/ganti_password_kadep.php"><i class="fa fa-pencil-square-o"></i>Ubah Password</a>
							</li>
							<li>
								<a href="../login/logout.php"><i class="fa fa-sign-out"></i> Log Out</a>
							</li>
						</ul>
					</li>
				</div>
			</div>
		</nav>
        <!-- /. NAV TOP  -->
		<main>
			<center>
			<h2>Daftar Dosen</h2>
			</center>
                 <!-- /. ROW  -->
                 <hr />
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Data Dosen
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
											<th> No </th>
											<th> NIP </th>
											<th> Nama </th>
											<th> Lihat </th>
										</tr>
                                    </thead>
										<?php view_dosen();?>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
            </main>


             <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->

    <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="../assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="../assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
	<script>
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();
			});
	</script>
         <!-- CUSTOM SCRIPTS -->
    <script src="../assets/js/custom.js"></script>


</body>
</html>
<?php
	}
	else
	{
		echo '<script language="javascript">alert("Anda Belum Login, Silahkan Login terlebih dahulu"); document.location="../index.html";</script>';
	}
?>
