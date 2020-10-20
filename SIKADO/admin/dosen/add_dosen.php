<?php
	require_once('../fungsiAdmin.php');
	require_once('../db_login.php');
	session_start();
	if (isset($_SESSION['username']) && ($_SESSION['password']))
	{
		$id = $_SESSION['username'];
		if (isset($_POST["submit"]))
		{
			$nip = test_input($_POST['nip']);
			if ($nip == "")
			{
				$error_nip = "NIP is required";
				$valid_nip = FALSE;
			}
			elseif (!preg_match("/^[0-9]*$/",$nip)) 
			{
				$error_nip = "* NIP hanya berisi angka";
				$valid_nip = FALSE;
			}
			else
			{
				$valid_nip = TRUE;
			}
			
			$nama = test_input($_POST['nama']);
			if ($nama == "")
			{
				$error_nama = "Nama is required";
				$valid_nama = FALSE;
			}
			elseif (!preg_match("/^[a-zA-Z ]*$/",$nama)) 
			{
				$error_nama = "* Hanya huruf dan spasi yang dibolehkan";
				$valid_nama = FALSE;
			}
			else
			{
				$valid_nama = TRUE;
			}
			
			$nidn = test_input($_POST['nidn']);
			if (!preg_match("/^[0-9]*$/",$nidn)) 
			{
				$error_nidn = "* NIDN hanya berisi angka";
				$valid_nidn = FALSE;
			}
			else
			{
				$valid_nidn = TRUE;
			}
			
			$gelar_depan = test_input($_POST['gelar_depan']);
			if (!preg_match("/^[a-zA-Z,. ]*$/",$gelar_depan)) 
			{
				$error_gelar_depan = "* hanya huruf, tanda '.', tanda ',' dan spasi yang dibolehkan";
				$valid_gelar_depan = FALSE;
			}
			else
			{
				$valid_gelar_depan = TRUE;
			}
			
			$gelar_belakang = test_input($_POST['gelar_belakang']);
			if (!preg_match("/^[a-zA-Z,. ]*$/",$gelar_belakang)) 
			{
				$error_gelar_belakang = "* hanya huruf, tanda '.', tanda ',' dan spasi yang dibolehkan";
				$valid_gelar_belakang = FALSE;
			}
			else
			{
				$valid_gelar_belakang = TRUE;
			}
			
			$email = test_input ($_POST['email']);
			
			$tempat_lahir = test_input($_POST['tempat_lahir']);
			if (!preg_match("/^[a-zA-Z,. ]*$/",$tempat_lahir)) 
			{
				$error_tempat_lahir = "* hanya huruf, tanda '.', tanda ',' dan spasi yang dibolehkan";
				$valid_tempat_lahir = FALSE;
			}
			else
			{
				$valid_tempat_lahir = TRUE;
			}
			$tanggal_lahir = test_input($_POST['tanggal_lahir']);
			$alamat_rumah = test_input($_POST['alamat_rumah']);
			$no_hp = test_input($_POST['no_hp']);
			if (!preg_match("/^[0-9+ ]*$/",$no_hp)) 
			{
				$error_no_hp = "* hanya angka dan tanda '+' yang dibolehkan";
				$valid_no_hp = FALSE;
			}
			else
			{
				$valid_no_hp = TRUE;
			}
			
			$scopus_id = test_input($_POST['scopus_id']);
		
		
			if ($valid_nip && $valid_nama && $valid_nidn && $valid_gelar_depan && $valid_gelar_belakang && $valid_tempat_lahir && $valid_no_hp)
			{
				$query = "SELECT nip FROM dosen";
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
						$nip_db = $row->nip;
						if ($nip_db == $nip)
						{
							$data_ulang = 1;		
						}
					}
					if ($data_ulang == 1)
					{
						echo '<script language="javascript">alert("Data dengan nip '.$nip.' telah terdaftar"); document.location="add_dosen.php";</script>';
						$db->close();
						exit;
					}
					else
					{
						$nip = $db->real_escape_string($nip);
						$nidn = $db->real_escape_string($nidn);
						$gelar_depan = $db->real_escape_string($gelar_depan);
						$nama = $db->real_escape_string($nama);
						$gelar_belakang = $db->real_escape_string($gelar_belakang);
						$email = $db->real_escape_string($email);
						//$password_enkrip = md5(md5($password));
						$password = "000000";
						$tempat_lahir = $db->real_escape_string($tempat_lahir);
						$tanggal_lahir = $db->real_escape_string($tanggal_lahir);
						$alamat_rumah = $db->real_escape_string($alamat_rumah);
						$no_hp = $db->real_escape_string($no_hp);
						$scopus_id = $db->real_escape_string($scopus_id);
							
						add_dosen($nip,$nidn,$gelar_depan,$nama,$gelar_belakang,$password,$email,$tempat_lahir,$tanggal_lahir,$alamat_rumah,$no_hp,$scopus_id);	
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
								<a href="../admin/ganti_password_admin.php?id=<?php echo $id;?>"><i class="fa fa-pencil-square-o"></i>Ubah Password</a>
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
                                <a class="active-menu" href="view_dosen.php">Dosen</a>
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
                     <h2>Tambah Dosen</h2>  
						<h5 class="error"> * wajib diisi </h5> 
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
				 <div class="row">
                <div class="col-md-12">
								<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data"/>
								
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">NIP</label>
											<div class="col-sm-4">
												<input type="text" name="nip" class="form-control" size="120" maxlength="50" placeholder="" value="<?php if (isset($nip)){echo $nip;}?>"></td>
												<span class="error">* <?php if (isset($error_nip)){echo $error_nip;}?></span>
											</div>
									</div>
									<div style="clear: both;"></div>
									
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">NIDN</label>
											<div class="col-sm-4">
												<input type="text" name="nidn" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($nidn)){echo $nidn;}?>"></td>
												<span class="error" style="padding : 10px" ><?php if (isset($error_nidn)){echo $error_nidn;}?></span>											</div>
									</div>
									<div style="clear: both;" ></div>
									
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Gelar Depan</label>
											<div class="col-sm-4">
												<input type="text" name="gelar_depan" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($gelar_depan)){echo $gelar_depan;}?>"></td>
												<span class="error" style="padding : 10px"> <?php if (isset($error_gelar_depan)){echo $error_gelar_depan;}?></span>
											</div>
									</div>
									<div style="clear: both;" ></div>
									
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Nama</label>
											<div class="col-sm-4">
												<input type="text" name="nama" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($nama)){echo $nama;}?>">
												<span class="error">* <?php if (isset($error_nama)){echo $error_nama;}?></span></td>
											</div>
									</div>
									<div style="clear: both;" ></div>
									
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Gelar Belakang</label>
											<div class="col-sm-4">
												<input type="text" name="gelar_belakang" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($gelar_belakang)){echo $gelar_belakang;}?>">
												<span class="error" style="padding : 10px"> <?php if (isset($error_gelar_belakang)){echo $error_gelar_belakang;}?></span>
											</div>
									</div>
									<div style="clear: both;" ></div>
									
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Email</label>
											<div class="col-sm-4">
												<input type="text" name="email" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($email)){echo $email;}?>">
												<span class="error" style="padding : 10px"> <?php if (isset($error_email)){echo $error_email;}?></span>
											</div>
									</div>
									<div style="clear: both;" ></div>
									
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Tempat Lahir</label>
											<div class="col-sm-4">
												<input type="text" name="tempat_lahir" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($tempat_lahir)){echo $tempat_lahir;}?>"></td>
												<span class="error" style="padding : 10px"> <?php if (isset($error_tempat_lahir)){echo $error_tempat_lahir;}?></span>
											</div>
									</div>
									<div style="clear: both;" ></div>
									
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Tanggal Lahir</label>
											<div class="col-xs-6 col-sm-3">
												<input type="date" name="tanggal_lahir" class="form-control" maxlength="50" placeholder="" value="<?php if (isset($tanggal_lahir)){echo $tanggal_lahir;}?>"></td>
												<span class="error" style="padding : 10px"></span>
											</div>
									</div>
									<div style="clear: both;" ></div>
										
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Alamat Rumah</label>
											<div class="col-sm-4">
												<textarea class="form-control" rows="3" name="alamat_rumah" maxlength="1000" value="<?php if (isset($alamat_rumah)){echo $alamat_rumah;}?>"></textarea></td>
												<span class="error" style="padding : 10px"></span>
											</div>
									</div>
									<div style="clear: both;" ></div>
									
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Nomor Hp/ Telepon</label>
											<div class="col-sm-4">
												<input type="text" name="no_hp" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($no_hp)){echo $no_hp;}?>"></td>
												<span class="error" style = "padding : 10px"> <?php if (isset($error_no_hp)){echo $error_no_hp;}?></span>
											</div>
									</div>
									<div style="clear: both;" ></div>
									
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label">Scopus ID</label>
											<div class="col-sm-4">
												<input type="text" name="scopus_id" class="form-control" size="30" maxlength="50" placeholder="" value="<?php if (isset($scopus_id)){echo $scopus_id;}?>"></td>
												<span class="error" style="padding : 10px">
											</div>
									</div>
									<div style="clear: both;" ></div>
									
									<div class="form-group">
										<label class="col-sm-2 col-sm-2 control-label"></label>
											<div class="col-sm-4">
												<input type="submit" class="btn btn-outline btn-primary" name="submit" value="Simpan"/></td>
											</div>
									</div>
									<div style="clear: both;" ></div>
								</form>
				</div>
            </div>

               
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
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
    
   
</body>
</html>
<?php
	}
	else
	{
		echo '<script language="javascript">alert("Anda Belum Login, Silahkan Login terlebih dahulu"); document.location="../../login.html";</script>';
	}
?>		
