<?php
ob_start(); 
session_start(); 
include "dbconnect.php";
include ('config.php'); 

	extract($_POST);
$servername = constant("DB_HOST");
$username = constant("DB_USERNAME");
$password = constant("DB_PASSWORD");
$dbname = constant("DB_NAME");

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

		 function getUserList(){ 
$servername = constant("DB_HOST");
$username = constant("DB_USERNAME");
$password = constant("DB_PASSWORD");
$dbname = constant("DB_NAME");
          

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM `user` ";
    
    $result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	
					   echo '<tr id=\'{$row["id"]}\'>';
                    echo "<td>{$row["id"]}</td>";
					echo "<td>{$row["fname"]}</td>";
					echo "<td>{$row["lname"]}</td>";
					echo "<td>{$row["username"]}</td>";
					echo "<td>{$row["password"]}</td>";
					echo "<td>{$row["usertype"]}</td>";
					echo "<td>{$row["pwreset"]}</td>";
                    echo "</tr>";     

    }
} 
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
                        <a   href="table.php"><i class="fa fa-table"></i> Istatistikler</a>
                    </li>
                    <li>
                        <a href="form.php"><i class="fa fa-edit"></i> Konfigürasyon </a>
                    </li>
                    <li>
                        <a class="active-menu" href="users.php"><i class="fa fa-users"></i> Kullanıcılar </a>
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
                            Tabloloar <small>Kullanıcı Bilgileri</small>
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
               
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Table  User List -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Kullanıcılar (1 Admin - 2 Desk)
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>İsim</th>
                                            <th>Soyisim</th>
                                            <th>Kullanıcı Adı</th>
                                            <th>Şifre</th>
                                            <th>Kullanıcı Tipi</th>
                                            <th>Şifre Sıfırlama</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php  

										getUserList();

                                    ?>
                                    
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End User List -->
                </div>
            </div>
            
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Kullanıcı Bilgileri <small>Kullanıcı Bilgileri Güncelleme</small>
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
              <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form name="entry" action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                                        <div class="form-group">
                                            <label>Kullanıcı ID:</label>
                                            <input class="form-control" placeholder="1" name="userId" id="userId">
                                          
                                        </div>
                                        <div class="form-group">
                                            <label>Kullanıcı Adı:</label>
                                            <input type="text" class="form-control" placeholder="sponsor1" name="userName" id="userName">
                                         
                                        </div>
                                               <div class="form-group">
                                            <label>Kullanıcı Şifre</label>
                                            <input type="password" class="form-control" placeholder="1234" name="userPassword" id="userPassword">
                                          
                                        </div>
                                               <div class="form-group">
                                            <label>Kullanıcı Tipi</label>
                                            <input type="text" class="form-control" placeholder="1" name="userType" id="userType">
                                            
                                        </div>
                                        
                                        <button type="submit" class="btn btn-default" name="userUpdate">Kaydet</button>
                                        <button type="reset" class="btn btn-default">Temizle</button>
                                    </form>
                                </div>

                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
			</div>
             <!-- /. PAGE INNER  -->
            
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
		<script type="text/javascript" src="media/js/complete.js"></script>
		<script src="media/js/jquery.min.js" type="text/javascript"></script>
        	<script src="media/js/jquery.dataTables.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="media/js/jquery.dataTables.editable.js"></script>
		<script src="media/js/jquery.jeditable.js" type="text/javascript"></script>
        	<script src="media/js/jquery-ui.js" type="text/javascript"></script>
        	<script src="media/js/jquery.validate.js" type="text/javascript"></script>
     
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable().makeEditable();
            });
    </script>

         <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    
   
</body>
</html>
