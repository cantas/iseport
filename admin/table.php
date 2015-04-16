<?php
ob_start(); 
session_start(); 
include "dbconnect.php";
	extract($_POST);
$servername = "localhost";
$username = "cantas_ise2";
$password = "Password1!";
$dbname = "cantas_ise";

	$dogrumu = $_SESSION['dogrumu'];
	$res = $dogrumu;
	$pwcount = $_SESSION['pwcount'];
	$user_id = $_SESSION['uid'];

  	if ($res != 1) {
    header("Location:../login.php");
    exit;
}

	
	if ($pwcount == 0)
	{
		
		
	}

		 function getVisitorList(){ 
$servername = "localhost";
$username = "cantas_ise2";
$password = "Password1!";
$dbname = "cantas_ise";
          

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM `visitor` ";
    
    $result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	
					   echo "<tr>";
                    echo "<td>{$row["id"]}</td>";
					echo "<td>{$row["identityNum"]}</td>";
					echo "<td>{$row["name"]}</td>";
					echo "<td>{$row["card_id"]}</td>";
					echo "<td>{$row["host"]}</td>";
					echo "<td>{$row["hostMail"]}</td>";
					echo "<td>{$row["entryTime"]}</td>";
					echo "<td>{$row["exitTime"]}</td>";
					echo "<td>{$row["desk_id"]}</td>";
					echo "<td>{$row["desk_id_exit"]}</td>";
                    echo "</tr>";     

    }
} 
$conn->close();
        }
        		 function getDeskPerformance(){ 
$count = 1;        		 
$servername = "localhost";
$username = "cantas_ise2";
$password = "Password1!";
$dbname = "cantas_ise";
          

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT u.fname as name , u.lname as surname, count( desk_id ) as total\n"
    . "FROM `visitor` v, user u\n"
    . "WHERE u.id = v.desk_id\n"
    . "GROUP BY `desk_id` LIMIT 0, 30 ";
    
    $result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	
					   echo "<tr>";
					echo "<td>$count</td>";
					$count++;
					echo "<td>{$row["name"]}</td>";
					echo "<td>{$row["surname"]}</td>";
					echo "<td>{$row["total"]}</td>";
                    echo "</tr>";     

    }
} 
$count = null;
$conn->close();
        }
                		 function getVistorPerformance(){ 
$count = 1;        		 
$servername = "localhost";
$username = "cantas_ise2";
$password = "Password1!";
$dbname = "cantas_ise";
          

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT round( count( `identityNum` ) ) as total , `identityNum` , `name` , `card_id` , `host`\n"
    . "FROM `visitor`\n"
    . "GROUP BY `identityNum`\n"
    . "ORDER BY count( `identityNum` ) DESC LIMIT 0, 30 ";
    
    $result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	
					   echo "<tr>";
					echo "<td>$count</td>";
					$count++;
					echo "<td>{$row["total"]}</td>";
					echo "<td>{$row["identityNum"]}</td>";
					echo "<td>{$row["name"]}</td>";
					echo "<td>{$row["card_id"]}</td>";
					echo "<td>{$row["host"]}</td>";

                    echo "</tr>";     

    }
} 
$count = null;
$conn->close();
        }

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Yönetim Paneli</title>
	<!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- Morris Chart Styles-->
   
        <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
     <!-- Google Fonts-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Yönetim</a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
              
                          <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li class="divider"></li>
                        <li><a href="../logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
               

                <!-- /.dropdown -->
            </ul>
        </nav>
        <!--/. NAV TOP  -->
               <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a  href="index.php"><i class="fa fa-dashboard"></i> Anasayfa</a>
                    </li>
					<li>
                        <a href="chart.php"><i class="fa fa-bar-chart-o"></i> Charts</a>
                    </li>
                    <li>
                        <a  class="active-menu" href="table.php"><i class="fa fa-table"></i> Istatistikler</a>
                    </li>
                    <li>
                        <a href="form.php"><i class="fa fa-edit"></i> Konfigürasyon </a>
                    </li>
                    <li>
                        <a href="users.php"><i class="fa fa-users"></i> Kullanıcılar </a>
                    </li>

                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Tablolar <small>Sistem Raporları</small>
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
               
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Table -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Son Kayıtlar
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>T.C</th>
                                            <th>İsim Soyisim</th>
                                            <th>Kart No</th>
                                            <th>Gelinen Kişi</th>
                                            <th>Gelinen Mail</th>
                                            <th>Giriş Tarihi</th>
                                            <th>Çıkış Tarihi</th>
                                            <th>Girişi Yapan</th>
                                            <th>Çıkışı Yapan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php  

										getVisitorList();

                                    ?>
                                    
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
                <!-- /. ROW  -->
            <div class="row">
                <div class="col-md-6">
                  <!--   TOP n Giriş -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            En çok kayıt yapanlar
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>İsim Soyisim</th>
                                            <th>Kart No</th>
                                            <th>Toplam Giriş İşlemi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
							getDeskPerformance();
									?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                     <!-- End  Visitor Performance -->
                </div>
                <div class="col-md-6">
                     <!--   Basic Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            En Çok Ziyaret Edenler
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ziyaret Sayisi</th>
                                            <th>T.C No</th>
                                            <th>Ziyaretçi İsim</th>
                                            <th>Ziyaretçi Soyisim</th>
                                             <th>Gelinen Kişi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        getVistorPerformance();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                      <!-- End  Visitor Performance  -->
                </div>
            </div>
                <!-- /. ROW  -->

        </div>
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
         <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    
   
</body>
</html>
