<?php
ob_start(); 
session_start(); 
include("dbconnect.php"); 
include ('config.php'); 

require_once('functions.php');
//include ("functions.php");
extract($_POST);
extract($_GET);
if(isset($err))
{
	   echo '<script language="javascript">';
	   echo 'alert("Yanlış Kullanıcı adı veya şifre")';
	   echo '</script>';
}


?>
  
<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
 <title>Ziyaretci Kayit Giris</title>
 <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>

  <link rel="stylesheet" href="css/normalize.css">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="./jquery.datetimepicker.css"/>
    <script type="text/javascript" src="./jquery.leanModal.min.js"></script>

<style type="text/css">

.custom-date-style {
  background-color: red !important;

}

  #lean_overlay {
    position: fixed;
    z-index:100;
    top: 0px;
    left: 0px;
    height:100%;
    width:100%;
    background: #000;
    display: none;
}

</style>
  <script src="../lib/sweet-alert.min.js"></script>
  <link rel="stylesheet" href="../lib/sweet-alert.css">
</head>

<body>
 <div class="form">
          <h1>Kullanıcı girişi</h1>
          <script>leanModal();</script>

		<form name="entry" action="<?= $_SERVER["PHP_SELF"] ?>" method="post">

            <div class="field-wrap">
              <label>
                Kullanici Adı<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name="loginName"/>
            </div>
            <div class="field-wrap">
            <label>
              Şifre <span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off" name="loginPass"/>
          </div>

          <button type="submit" class="button button-block"  name="userLogin" />Giriş</button>

          </form>

      
    </div> <!-- /form -->
<?php
/* Guest Enter Operation */
if(isset($userLogin))
	{
			/*$res = login($username, $userpass);

			$_SESSION['dogrumu']=$res;
			if($res == 1) // User
    			header("location:admin.php");
				else  if($res == 2) // admin
    			header("Location:index.php");
				else
                header("Location:login.php?err=on&username=$username&password=$userpass&usertype=$res"); 
                
                */	
                
            
        
                
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


    $sql = "select * from user where username='$loginName' and password='$loginPass'";
    
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
        $rec = $result->fetch_assoc();
        $_SESSION["authenticate"] = "OK";
        $_SESSION["uid"] = $rec["id"];
        $_SESSION["fname"] = $rec["fname"];
        $_SESSION["lname"] = $rec["lname"];
        $_SESSION["utype"] = $rec["usertype"];
        $_SESSION["pwcount"] = $rec["pwreset"];
        $res = $rec["usertype"];
        $_SESSION['dogrumu']=$res;

        	if($res == 1) // User
    			header("location:admin/index.php?type=$res");
				else  if($res == 2) // admin
    			header("Location:index.php");
				else
                header("Location:login.php?err=on&username=$username&password=$userpass&usertype=$res");
        
		
    }
    else
    {
    	header("Location:login.php?err=on&username=$username&password=$userpass&usertype=$res");

    }
	}
?>
  <script src='http://codepen.io/assets/libs/fullpage/jquery.js'></script>
  <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>

  <!-- This is what you need -->
  <script src="/lib/sweet-alert.min.js"></script>
  <link rel="stylesheet" href="/lib/sweet-alert.css">
  <script src="js/index.js"></script>
  <script src="./jquery.datetimepicker.js"></script>
  
  <script type="text/javascript">
 function a(){
 swal("Here's a message!");
 };
</script>
</body>
</html>