<?php
require_once('../redirecter.php');
require_once('../db_login.php');
require_once('../fungsiMhs.php');
//session_start();
if (isset($_SESSION['username'])&& ($_SESSION['password']))
{
	if (isset($_GET['id']))
	{
		$nip = $_GET['id'];
	}

	//Deklarasi nama bulan
	$monthNames = Array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
											"Agustus", "September", "Oktober", "November", "Desember");

	if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
	if (!isset($_REQUEST["year"])) $_REQUEST["year"]   = date("Y");

	$cMonth = $_REQUEST["month"];
	$cYear  = $_REQUEST["year"];

	$prev_year  = $cYear;
	$next_year  = $cYear;
	$prev_month = $cMonth-1;
	$next_month = $cMonth+1;

	if($prev_month == 0 )
	{
		$prev_month = 12;
		$prev_year = $cYear - 1;
	}

	if($next_month == 13 )
	{
		$next_month = 1;
		$next_year = $cYear + 1;
	}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Jadwal Dosen</title>
	<!-- BOOTSTRAP STYLES-->
	<link href="../../assets/css/bootstrap.css" rel="stylesheet" />
	<!-- FONTAWESOME STYLES-->
	<link href="../../assets/css/font-awesome.css" rel="stylesheet" />
	<!-- CUSTOM STYLES-->
	<link href="../../assets/css/custom.css" rel="stylesheet" />
	<!-- DROPDOWN STYLES-->
	<link href="../../assets/css/dropdown.css" rel="stylesheet" />
	<link href="../../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
	<link rel="shortcut icon" href="../login/assets/img/undip.png"/>
	<link rel="stylesheet" href="../../assets/css/style_tab.css">
	<!-- GOOGLE FONTS-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

	<!--style untuk tabel kalender-->
	<style type="text/css">
		table
		{
			border : 0px solid #000000;
		}
		th
		{
			background-color : #4682B4;
			color            : #FFFFFF;
		}
	</style>

	<link href="popup.css" rel="stylesheet">


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
								<a class="navbar-brand" href="../"><img src="../../assets/img/logo.png" height="50px"></a>
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
								<a href="../../login/logout.php"><i class="fa fa-sign-out"></i> Log Out</a>
							</li>
						</ul>
					</li>
				</div>
			</div>
		</nav>
		<main>
        <!-- /. NAV SIDE  -->

            <div id="page-inner">
							<center>
							<h2>Jadwal <?php view_nama_dosen($nip); ?></h2>
							</center>
                 <!-- /. ROW  -->
                 <hr />
                <div class="row"></div>
                <div class="row">
                <div class="col-md-12">
									<!--Menampilkan kalender-->
							    <table class="table table-striped table-bordered table-hover" id="dataTables-example">

							      <tr>
							        <!--Untuk tombol prev-->
							        <td align="center" colspan="7"><a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year . "&id=" . $nip; ?>" class="btn btn-default btn-md">&lt;</a>
							        <!--Untuk nama bulan-->
							        <strong class="btn btn-primary btn-md disabled" id="demo"><?php echo $monthNames[$cMonth-1].' '.$cYear; ?></strong>
							        <!--Untuk tombol next-->
							        <a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year . "&id=" . $nip; ?>" class="btn btn-default btn-md">&gt;</a></td>
							      </tr>

							      <tr>
							        <th align="center" width=150>Minggu</th>
							        <th align="center" width=150>Senin</th>
							        <th align="center" width=150>Selasa</th>
							        <th align="center" width=150>Rabu</th>
							        <th align="center" width=150>Kamis</th>
							        <th align="center" width=150>Jum'at</th>
							        <th align="center" width=150>Sabtu</th>
							      </tr>

							      <?php
							      //untuk pengaturan tanggal per bulannya
							        $timestamp = mktime(0,0,0,$cMonth,1,$cYear); //untuk bikin timestamp sendiri
							        $maxday    = date("t",$timestamp);
							        $thismonth = getdate ($timestamp);
							        $startday  = $thismonth['wday'];
							        for ($i=0; $i<($maxday+$startday); $i++)
							        {
							          if(($i % 7) == 0 )
							          {
							            echo "<tr>";
							          }

							          if($i < $startday)
							          {
							            echo "<td></td>";
							          }
							          else
							          {
							            //ngambil agenda per tanggal
										$servername = "localhost";
										$username = "root";
										$password = "";
										$dbname = "db_sid_statistika";

										// Membuat Koneksi
										$koneksi = new mysqli($servername, $username, $password, $dbname);
										
										// Melakukan Cek Koneksi
										if ($koneksi->connect_error) {
											die("Koneksi Gagal : " . $koneksi->connect_error);
										} 

										//Melakukan query
										$query    = "SELECT * FROM jadwal WHERE tanggal ='".$cYear.'-'.$cMonth.'-'.($i - $startday + 1)."' AND nip = '".$nip."'";
										$result = $koneksi->query($query);
										$jmlAcara = mysqli_num_rows($result);
										
							            echo "<td valign='top' height='130px'".($jmlAcara > 0 ? " " : '').">";
							            echo ($i - $startday + 1);

							            if($jmlAcara > 0)
							            {
							              if ($result->num_rows > 0) {
											foreach ($result as $row) {
							              {
							                echo"<br><div><a href='#detail_agenda' id='custId' data-toggle='modal' data-id=".$row['id_jadwal']." style=text-decoration:none;><font size=2>".$row['nama_acara']."</font></a></div>";
							              }
											}
										  }
							            echo "</td>";
							          }

							          if(($i % 7) == 6 )
							          {
							            echo "</tr>";
							          }
							        }
									}
							      ?>
							    </table>


                </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
				 <p><a class="btn btn-outline btn-danger" href= "../blank_mahasiswa.php"><i class="fa fa-arrow-circle-left fa-fw"></i> Kembali</a></p>
        </div>
				</main>
				</div>
		<div class="modal fade" id="detail_agenda" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Detail Agenda</h4>
                </div>
                <div class="modal-body">
                    <div class="fetched-data"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                </div>
            </div>
        </div>
    </div>
 
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $('#detail_agenda').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'detail_agenda.php',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
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
