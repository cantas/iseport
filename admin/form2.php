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

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
   		 die("Connection failed: " . $conn->connect_error);
		}
	$sqlCorpInfo = "SELECT `kurumAdi` , `kurumIseIp` as ise,`kurumIsePassword` as kurumpass, `kurumIseUsername` as kurumIseUsername FROM `corporation_config`";
	$result2 = $conn->query($sqlCorpInfo);

if ($result2->num_rows > 0) {
    // output data of each row
    while($row2 = $result2->fetch_assoc()) {
    
    $kurumAdi = $row2["kurumAdi"];
    $kurumIse = $row2["ise"];
 	$kurumIsePass = $row2["kurumpass"];
 	$kurumIseUsername = $row2["kurumIseUsername"];
       
    }
    
} 
	if(isset($saveBtn))
	{
		if(!empty($iseIP) || !empty($iseUsername) || !empty($isePassword) || !empty($corpName))
		{
			$sql = "UPDATE corporation_config SET id = 1 "; 
		
			if(!empty($iseIP))
			{
			$sql = $sql . " ,kurumIseIp = '$iseIP' ";
			}
		
			if(!empty($iseUsername))
			{
			$sql = $sql . " ,kurumIseUsername = '$iseUsername' ";
			}
		
			if(!empty($isePassword))
			{
			$sql = $sql . " ,kurumIsePassword = '$isePassword' ";
			}
		
			if(!empty($corpName))
			{
			$sql = $sql . " ,kurumAdi = '$corpName' ";
			}
		
			$sql .= " WHERE id = 1 ";
		
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
		if($conn->query($sql) === TRUE )
  		 {
     	echo '<script language="javascript">';
	  	 	echo 'alert("Kurum Bilgileri Guncellendi")';
	  	 echo '</script>';
   			}
   	else
   {
      echo '<script language="javascript">';
      echo 'alert("Error Occured - Kurum Bilgi Guncelleme")';
      echo '</script>';

   }

 }
	
	}
	elseif(isset($savePortalBtn))
	{
	   $portal_id = $_POST['portalId'];
			$sql = "UPDATE corporation_config SET portal_id = '$portal_id' "; 
						$sql .= " WHERE id = 1 ";
		
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
		if($conn->query($sql) === TRUE )
  		 {
     	echo '<script language="javascript">';
	  	 	echo 'alert("Portal Id Guncellendi")';
	  	 echo '</script>';
   			}
   	else
   {
      echo '<script language="javascript">';
      echo 'alert("Error Occured - Portal Id Guncellenemedi"")';
      echo '</script>';

   }
	}
	



?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cisco ISE Yönetim Paneli - Konfigürasyon</title>
	<!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
     <!-- Google Fonts-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
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
                <a class="navbar-brand" href="admin.php">Yönetim </a>
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
                        <a class="active-menu" href="form.php"><i class="fa fa-edit"></i> Konfigürasyon </a>
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
                            Sistem Konfigürasyon <small>Kurum bilgileri ve Cisco ISE bilgileri</small>
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
                                            <label>Kurum Adı</label>
                                            <input class="form-control" placeholder="ör: AFAD, Sağlık Bakanlığı vs." name="corpName">
                                             <?php echo "Varsayılan : " . "$kurumAdi"; ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Cisco ISE (Identity Service Engine) IP Adresi</label>
                                            <input type="text" class="form-control" placeholder="10.10.10.12" name="iseIP">
                                            <?php echo "Varsayılan : " . "$kurumIse"; ?>
                                        </div>
                                               <div class="form-group">
                                            <label>Cisco ISE (Identity Service Engine) Kullanıcı Adı</label>
                                            <input type="text" class="form-control" placeholder="root" name="iseUsername">
                                            <?php echo "Varsayılan : " . "$kurumIseUsername"; ?>
                                        </div>
                                               <div class="form-group">
                                            <label>Cisco ISE (Identity Service Engine) Şifre</label>
                                            <input type="password" class="form-control" placeholder="********" name="isePassword">
                                            <?php echo "Varsayılan : " . "*********"; ?>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-default" name="saveBtn">Kaydet</button>
                                        <button type="reset" class="btn btn-default">Temizle</button>
                                    </form>
                                </div>
								                        <div class="col-lg-6">
                                    <form name="entry" action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                                       
                                               <div class="form-group">
                                            <label>ISE Portal ID:</label>
<?php

// This is what we're testing
require_once('Rest.php');

		$servername = constant("DB_HOST");
$username = constant("DB_USERNAME");
$password = constant("DB_PASSWORD");
$dbname = constant("DB_NAME");
		//$conn2 = null;
		// Create connection
		//$conn2 = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
   		 die("Connection failed: " . $conn->connect_error);
		}
	$sqlCorpInfo2 = "SELECT `kurumAdi` , `kurumIseIp` as ise,`kurumIsePassword` as kurumpass, `kurumIseUsername` as kurumIseUsername, `sponsor_user_name` as sponsor, `sponsor_user_password` as sponsor_password FROM `corporation_config` LIMIT 0, 30 ";
	$result3 = $conn->query($sqlCorpInfo2);

if ($result3->num_rows > 0) {
    // output data of each row
    while($row3 = $result3->fetch_assoc()) {
    
    $kurumAdi = $row3["kurumAdi"];
    $kurumIse = $row3["ise"];
 	$kurumIsePass = $row3["kurumpass"];
 	$kurumIseUsername = $row3["kurumIseUsername"];
	$sponsor = $row3["sponsor"];
	$sponsor_password = $row3["sponsor_password"];
    }
    
} 

$rest = new Rest( 
			$sponsor,
			$sponsor_password,
			'https://'.$kurumIse.':9060/ers/config/portal',
			'Accept: application/vnd.com.cisco.ise.identity.portal.2.0+xml' );

$rest->get();

// Determine the result and output
if( $rest->http->code == 200 )
{
//echo "rr :". htmlspecialchars( print_r($rest->http->response, true) ) ;

$xml=simplexml_load_string($rest->http->response) or die("Error: Cannot create object");

$p = xml_parser_create();
xml_parse_into_struct($p, $rest->http->response, $vals, $index);
xml_parser_free($p);

//print_r($vals);
/*
echo $vals[0]['attributes']['TOTAL']. "<br />";
echo $vals[2]['attributes']['NAME']. "<br />";
echo $vals[2]['attributes']['ID']. "<br />";


*/                        			
									$portal_cnt = $vals[0]['attributes']['TOTAL'];
									echo	'<select name="portalId">';
									echo	'<option selected="selected" disabled="disabled" value="none">Portal Seciniz</option>';

									for($i = 2; $i<$portal_cnt * 3 ; $i+=3){
									echo	'<option value="'.$vals[$i]["attributes"]["ID"].'">'.$vals[$i]["attributes"]["NAME"].'</option>';
									}
									echo	'</select>';


}
?>
                                            
                                        </div>
                                        
                                        <button type="submit" class="btn btn-default" name="savePortalBtn">Kaydet</button>
                                     
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
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    
   
</body>
</html>
