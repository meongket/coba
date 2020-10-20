<?php
	require_once('../redirecter.php');
	require_once('../fungsiKadep.php');
	require_once('../db_login.php');
	//session_start();
	if (isset($_SESSION['username']) && ($_SESSION['password']))
	{
		$query = "SELECT password FROM kadep WHERE username = 'kadep' ";
		$result = $db->query($query);
		if (!$result)
		{
			die ("Could not query the database: <br />". $db->error);
		}
		else {
			$row = $result->fetch_object();
			$password = $row->password;
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

				force_ganti_password_kadep($password_baru);
			}
		}
?>

<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Ketua Departemen</title>
		<!-- BOOTSTRAP STYLES-->
		<link href="../../assets/css/bootstrap.css" rel="stylesheet" />
		 <!-- FONTAWESOME STYLES-->
		<link href="../../assets/css/font-awesome.css" rel="stylesheet" />
		<!-- CUSTOM STYLES-->
		<link href="../../assets/css/custom.css" rel="stylesheet" />
		<!-- DROPDOWN STYLES-->
		<link href="../../assets/css/dropdown.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../assets/css/style.css">
		<!--<link rel="stylesheet" href="css/perusahaan.css" />
		<!--mau nambahin dropdwon tapi masih gagal-->
		 <!-- STYLES LOGOUT -->
		<link href="../../assets/css/style.css" rel="stylesheet" />
		<!-- TABLE STYLES-->
		<link href="../../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
		<!-- GOOGLE FONTS-->
	   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	   <link rel="shortcut icon" href="../../login/assets/img/undip.png"/>

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
		                <a class="navbar-brand" href="../"><img src="../../login/assets/img/logo.png" height="50px"></a>
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
				<!-- Page Content -->
				<div class="login">
					<main>
					<form method="post">
						<br>
						<input type="password" name="password_lama" id= "password_lama" class="form-control" size="30" maxlength="50" placeholder="Masukkan Password Lama" onkeyup="Konfirm()" value="<?php if (isset($password_lama)){echo $password_lama;}?>">
						<span class="error">* <?php if (isset($error_password_lama)){echo $error_password_lama;}?></span>
						<br>
						<input type="password" name="password_baru" id="password_baru" class="form-control" size="30" maxlength="50" placeholder="Masukkan Password Baru" onkeyup="Konfirm()" value="<?php if (isset($password_baru)){echo $password_baru;}?>">
						<span class="error">* <?php if (isset($error_password_baru)){echo $error_passwword_baru;}?></span>
						<br>
						<input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control" size="30" maxlength="50" placeholder="Konfirmasi Password Baru" onkeyup="Konfirm()" value="<?php if (isset($konfirmasi_password)){echo $konfirmasi_password;}?>">
						<span class="error">* <?php if (isset($error_konfirmasi_password)){echo $error_konfirmasi_password;}?></span>
						<br>
						<input type="submit" class="btn btn-outline btn-primary" name="submit" id="submit" value="Submit" disabled />
					</form>
				</main>
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
		echo '<script language="javascript">alert("Anda Belum Login, Silahkan Login terlebih dahulu"); document.location="../../index.html";</script>';
	}
?>
