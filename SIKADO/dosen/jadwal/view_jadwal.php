<?php
	require_once('../redirecter.php');
	require_once('../fungsi_dosen.php');
	//session_start();
	require_once  ("../db_login.php");
	if(!isset($_SESSION['username']))
	{
		header('location:../index.hmtl');
	}
	$id_user = $_SESSION['username'];
	$name = $_SESSION['nama'];
	$nip = $_SESSION['username'];

	date_default_timezone_set("Asia/Jakarta");
	$namaHari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
	$namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

	if(isset($_GET['d'])){
		$d = $_GET['d'];
		$m = $_GET['m'];
		$Y = $_GET['Y'];
		$jam = date("H:i:s");
		$jamjav = date("H,i,s");
		$tanggal = new DateTime("$Y-$m-$d $jam", new DateTimeZone("Asia/Jakarta"));
	}
	else {
		//mktime(hour,minute,second,month,day,year)
		$tanggal = new DateTime("now", new DateTimeZone("Asia/Jakarta"));
		$d = $tanggal->format('d');
		$m = $tanggal->format('m');
		$Y = $tanggal->format('Y');
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
        <!-- CUSTOM STYLES-->
    <link href="../../assets/css/custom.css" rel="stylesheet" />
	<link href="../../assets/css/dropdown.css" rel="stylesheet" />
	<link href="../../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   <link rel="shortcut icon" href="../../login/assets/img/undip.png">

   <link rel="stylesheet" type="text/css" href="../../assets/calendar/dhtmlxcalendar.css"/>
   <script src="../../assets/calendar/dhtmlxcalendar.js"></script>
   <script>
		var myCalendar;
		function doOnLoad() {
			var jam = new Date();
			myCalendar = new dhtmlXCalendarObject({button: "selectcalendar"});
			myCalendar.setDate(new Date(<?php echo "$Y,$m-1,$d";?>,jam.getHours(),jam.getMinutes(),jam.getSeconds()));
			myCalendar.attachEvent("onClick", function(){
				var di = myCalendar.getFormatedDate("%d");
				var mi = myCalendar.getFormatedDate("%m");
				var yi = myCalendar.getFormatedDate("%Y");
				var urlwaktu = "?d=" + di + "&m=" + mi + "&Y=" + yi;
				window.location=urlwaktu;
			});
		}
   </script>

	 <script>
 	function Konf1(z)
 	{
 		var result = confirm("Anda yakin ingin menghapus data ini?");
 		if (result)
 		{
 			document.location = "delete_jadwal.php?id="+z;
 		}
 	}
 	</script>
</head>
<body onload="doOnLoad();">
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
											<a href="../akun/ganti_password_dosen.php?id=<?php echo $nip;?>"><i class="fa fa-pencil-square-o"></i>Ubah Password</a>
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
						$result->free();
						$db->close();
						?>
					</li>
					<li>
						<a  class="active-menu" href="#"><i class="fa fa-table fa-3x"></i>Lihat Jadwal Harian</a>
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
								<a href="../pengabdian/view_pengabdian.php">Pengabdian</a>
							</li>
						</ul>
					</li>
                </ul>
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
				<h2> Jadwal Harian </h2>
                 <!-- /. ROW  -->
                 <hr />
                <div class="row text-center">
					<div class="btn-group">
						<a href="?<?php echo 'd='.$tanggal->modify('-1 days')->format('d').'&m='.$tanggal->format('m').'&Y='.$tanggal->format('Y')?>" class="btn btn-default btn-md">&lt;</a>
						<a href="?<?php echo 'd='.$tanggal->modify('-2 days')->format('d').'&m='.$tanggal->format('m').'&Y='.$tanggal->format('Y')?>" class="btn btn-warning btn-md hidden-xs hidden-sm" id="demo" ><?php echo $tanggal->format('d F Y'); ?></a>
						<a href="?<?php echo 'd='.$tanggal->modify('+1 days')->format('d').'&m='.$tanggal->format('m').'&Y='.$tanggal->format('Y')?>" class="btn btn-warning btn-md hidden-xs hidden-sm" id="demo" ><?php echo $tanggal->format('d F Y'); ?></a>
						<a href="?<?php echo 'd='.$tanggal->modify('+1 days')->format('d').'&m='.$tanggal->format('m').'&Y='.$tanggal->format('Y')?>" class="btn btn-warning btn-md hidden-xs" id="demo" ><?php echo $tanggal->format('d F Y'); ?></a>
						<a href="?<?php echo 'd='.$tanggal->modify('+1 days')->format('d').'&m='.$tanggal->format('m').'&Y='.$tanggal->format('Y')?>" class="btn btn-warning btn-md disabled" id="demo" ><?php echo $tanggal->format('d F Y'); ?></a>
						<a href="?<?php echo 'd='.$tanggal->modify('+1 days')->format('d').'&m='.$tanggal->format('m').'&Y='.$tanggal->format('Y')?>" class="btn btn-warning btn-md hidden-xs" id="demo" ><?php echo $tanggal->format('d F Y'); ?></a>
						<a href="?<?php echo 'd='.$tanggal->modify('+1 days')->format('d').'&m='.$tanggal->format('m').'&Y='.$tanggal->format('Y')?>" class="btn btn-warning btn-md hidden-xs" id="demo" ><?php echo $tanggal->format('d F Y'); ?></a>
						<a href="?<?php echo 'd='.$tanggal->modify('+1 days')->format('d').'&m='.$tanggal->format('m').'&Y='.$tanggal->format('Y')?>" class="btn btn-warning btn-md hidden-xs hidden-sm" id="demo" ><?php echo $tanggal->format('d F Y'); ?></a>
						<a href="?<?php echo 'd='.$tanggal->modify('-2 days')->format('d').'&m='.$tanggal->format('m').'&Y='.$tanggal->format('Y')?>" class="btn btn-default btn-md">&gt;</a>
						<?php $tanggal->modify('-1 days'); ?>
						<button id="selectcalendar" class="btn btn-default btn-md"><i class="glyphicon glyphicon-calendar btn-md"></i> Pilih Tanggal</button>
					</div>
                </div>
                <div class="row"><br><br></div>
                <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Jadwal Harian
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
											<th> No </th>
											<th> Nama Acara </th>
											<th> Waktu Mulai </th>
											<th> Waktu Selesai </th>
											<th> Tempat </th>
											<th> Keterangan </th>
											</tr>
                                    </thead>
									<?php view_jadwal($nip,$tanggal);?>
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
