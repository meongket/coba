<?php
function test_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	session_start();
	if (isset($_SESSION['username']) && ($_SESSION['password']))
	{
		require_once('../db_login.php');
		$id = $_GET['id'];
		$db = new mysqli($db_host, $db_username, $db_password, $db_database);
		if ($db->connect_errno)
		{
			die ("Could not connect to the database: <br />". $db->connect_error);
		}
		
		$query = "SELECT * FROM admin WHERE username = '".$id."'";
		$result = $db->query($query);
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else
		{
			while ($row = $result->fetch_object())
			{
				$password = $row->password;	
			}
		}
		if (isset($_POST["submit"]))
		{
			$password_lama = test_input($_POST['password_lama']);
			if ($password_lama == "")
			{
				$error_password_lama = "Password Lama is required";
				$valid_password_lama = FALSE;
			}
			else if ($password_lama != $password)
			{
				$error_password_lama = "Password Lama tidak benar";
				$valid_password_lama = FALSE;
			}
			else
			{
				$valid_password_lama = TRUE;
			}
			
			$password_baru = test_input($_POST['password_baru']);
			if ($password_baru == "")
			{
				$error_password_baru = "Password Baru is required";
				$valid_password_baru = FALSE;
			}
			else
			{
				$valid_password_baru = TRUE;
			}
			
			
			$konfirmasi_password = test_input($_POST['konfirmasi_password']);
			if ($konfirmasi_password == "")
			{
				$error_konfirmasi_password = "konfirmasi_password is required";
				$valid_konfirmasi_password = FALSE;
			}
			else
			{
				$valid_konfirmasi_password = TRUE;
			}
			
			if ($valid_password_baru && $valid_password_lama && $valid_konfirmasi_password)
			{
				$password_lama = $db->real_escape_string($password_lama);
				$password_baru = $db->real_escape_string($password_baru);
				$konfirmasi_password = $db->real_escape_string($konfirmasi_password);
				
				
				$query1 = "UPDATE admin SET password = '".$password_baru."' WHERE username = '".$id."' ";
				// Execute the query
				$result1 = $db->query($query1);
				if (!$result1)
				{
				   die ("Could not query the database: <br />". $db->error);
				}
				else
				{
					echo '<script language="javascript">alert("Data berhasil diganti. Data yang dimasukkan memiliki password = '.$password_baru.'"); document.location="../dosen/view_dosen.php";</script>';
					$db->close();
					exit;
				}
			}
		}	
?>
	<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<title>Ganti Password</title>
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
			<script>
				function Konfirm()
				{
					if (!(document.getElementById("password_baru").value))
					{
						document.getElementById("submit").setAttribute("disabled","disabled");
					}
					else if ((document.getElementById("password_baru").value)==(document.getElementById("konfirmasi_password").value))
					{
						document.getElementById("submit").removeAttribute("disabled");
					}
					else if ((document.getElementById("password_baru").value)!=(document.getElementById("konfirmasi_password").value))
					{
						document.getElementById("submit").setAttribute("disabled","disabled");
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
								<a href="#"><i class="fa fa-pencil-square-o"></i>Ubah Password</a>
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
                                <a href="../mahasiswa/view_mahasiswa.php">Mahasiswa</a>  
                            </li>
                        </ul>
                      </li>  
                </ul>
               
            </div>
            
        </nav> 
				<!-- Page Content -->
				<div id="page-wrapper" >
				<div id="page-inner">
                <div class="row">
					<div class="col-md-12">
					<h2>Ganti Password</h2>
					</div>
                </div>
				<!-- /. ROW  -->
                 <hr />
				<!-- Page Content -->
				<div class="row">
					<div class="col-md-12">
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?id='.$id;?>" method="post" enctype="multipart/form-data"/>
								<div class="form-group">
									<label class="col-sm-3 col-sm-3"> Masukkan Password Lama </label>
									<div class="col-sm-3">
										<input type="password" name="password_lama" id= "password_lama" class="form-control" size="30" maxlength="50" placeholder="" onkeyup="Konfirm()" value="<?php if (isset($password_lama)){echo $password_lama;}?>"></td>
										<span class="error">* <?php if (isset($error_password_lama)){echo $error_password_lama;}?></span>
									</div>
								</div>
								<div style="clear: both;" /></div>
								
								<div class="form-group">
									<label class="col-sm-3 col-sm-3"> Masukkan Password Baru </label> 
									<div class="col-sm-3">
										<input type="password" name="password_baru" id="password_baru" class="form-control" size="30" maxlength="50" placeholder="" onkeyup="Konfirm()" value="<?php if (isset($password_baru)){echo $password_baru;}?>">
										<span class="error">* <?php if (isset($error_password_baru)){echo $error_passwword_baru;}?></span>
									</div>
								</div>
								<div style="clear: both;" /></div>
								
								<div class="form-group">
									<label class="col-sm-3 col-sm-3"> Konfirmasi Password Baru </label>
									<div class="col-sm-3">
										<input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control" size="30" maxlength="50" onkeyup="Konfirm()" value="<?php if (isset($konfirmasi_password)){echo $konfirmasi_password;}?>">
										<span class="error">* <?php if (isset($error_konfirmasi_password)){echo $error_konfirmasi_password;}?></span>
										</div>
									</div>
								<div style="clear: both;" /></div>
								
								<br/>
								<div class="form-group">
								<label class="col-sm-3 col-sm-3"></label>
									<div class="col-sm-3">
										<input type="submit" class="btn btn-outline btn-primary" name="submit" id="submit" value="Simpan" disabled />
									</div>
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
				<!-- /. WRAPPER  -->
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
		echo '<script language="javascript">alert("Anda Belum Login, Silahkan Login terlebih dahulu"); document.location="../login.html";</script>';
	}
?>
