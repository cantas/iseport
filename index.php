<?php

	include ('config.php');

	include "dbconnect.php";
	include 'functions.php';
	extract($_POST);
	
	$dogrumu = $_SESSION['dogrumu'];
	$res = $dogrumu;
	$pwcount = $_SESSION['pwcount'];
	$user_id = $_SESSION['uid'];

  	if ($res != 2) {
    header("Location:login.php");
    exit;
}	
	if ($pwcount == 0)
	{
		
		
	}

  // Get kurum information
  /**
  *@ise = Kurum Adı
  *@ise = Kurum Ise IP Address
  *@kurumpass = Kurum Ise Password
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

$sql = "SELECT `kurumAdi` , `kurumIseIp` as ise,`kurumIsePassword` as kurumpass FROM `corporation_config`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    
    $kurumAdi = $row["kurumAdi"];
    $kurumIse = $row["ise"];
 	$kurumIsePass = $row["kurumpass"];
       // echo "id: " . $row["kurumAdi"]. " - Name: " . $row["ise"]. " " . $row["kurumpass"]. "<br>";
    }
} else {
    echo "Lütfen sistem yoneticisine kurum bilgileri tablosunu guncellemesini belirtiniz.";
}
/*
    global $dbObj;
    $sqlGetCorpo = "SELECT `kurumAdi` , `kurumIseIp` as ise,`kurumIsePassword` as kurumpass FROM `corporation_config` ";

            //$result = $dbObj->query($sqlGetCorpo);

            $result = $dbObj->query("SELECT `kurumAdi` , `kurumIseIp` as ise,`kurumIsePassword` as kurumpass FROM `corporation_config` ");

          if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "adi: " . $row["kurumAdi"]. " - ip: " . $row["ise"]. "  sifre " . $row["kurumpass"]. "<br>";
    }
} else {
    echo "0 results";
}     
      */  
	?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
 <title><?php echo "$kurumAdi Ziyaretçi Kayıt Formu" ?></title>
 <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>

  <link rel="stylesheet" href="css/normalize.css">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="./jquery.datetimepicker.css"/>
<style type="text/css">

.custom-date-style {
  background-color: red !important;
}

</style>
  <script src="../lib/sweet-alert.min.js"></script>
  <link rel="stylesheet" href="../lib/sweet-alert.css">
</head>

<body>
 <div class="form">
  <ul class="tab-group">
        <li class="tab active"><a href="#giris">GIRIS</a></li>
        <li class="tab"><a href="#cikis">CIKIS</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
	<div class="tab-content">
        <div id="giris">   
          <h1>Ziyaretçi Kayıt</h1>

		<form name="entry" action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
            <div class="field-wrap">
            <label>
              T.C Kimlik No.<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" id="users" class="typeahead input-lg form-control" name="identityNum"/>
          </div>

          <div class="top-row">
            <div class="field-wrap">
              <label>
                İsim<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name="name"/>
            </div>

            <div class="field-wrap">
              <label>
                Soyisim<span class="req">*</span>
              </label>
              <input type="text"required autocomplete="off" name="surname"/>
            </div>
          </div>
            <div class="field-wrap">
            <label>
              Ziyarete Gelinen Kişi<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" name="hostName"/>
          </div>

          <div class="field-wrap">
            <label>
              Email Adres<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off" name="hostMail"/>
          </div>
          <div class="field-wrap">
            <label>
              Giriş Saati<span class="req">*</span>
            </label>
            <input type="text" id="datetimepicker7" name="entryTime"/>
          </div>

          <button type="submit" class="button button-block"  name="guestEnter" />Kaydet</button>

          </form>

        </div>

        <div id="cikis">   
           <h1>Ziyaretçi Çıkış</h1>

		<form name="exit" action="<?= $_SERVER["PHP_SELF"] ?>" method="post">

            <div class="field-wrap">
            <label>
              T.C Kimlik No.<span class="req">*</span>
            </label>
            <input type="text" 
                   required autocomplete="off" name="identityNumExit"/>
          </div>

          <div class="field-wrap">
            <label>
              Çıkış Saati<span class="req">*</span>
            </label>
            <input type="text" id="datetimepicker71" name="exitTime"/>
          </div>

          <button class="button button-block" name="guestExit" />Kaydet</button>

          </form>

        </div>

      </div><!-- tab-content -->

</div> <!-- /form -->


<?php
/* Guest Enter Operation */
if(isset($guestEnter))
		{
       //Record guestEnter event SQL
          $sqlEnter = "INSERT INTO `visitor` ( `identityNum` , `name` , `surname` , `host` , `hostMail` , `entryTime` , `desk_id`)\n"
    . "VALUES ('$identityNum','$name', '$surname', '$hostName', '$hostMail', str_to_date( '$entryTime', '%d/%m/%Y %H:%i') , $user_id ) ";
   if($dbObj->query($sqlEnter) === TRUE )
   {
     echo '<script language="javascript">';
	   echo 'alert("Ziyaretçi girişi kaydedildi.")';
	   echo '</script>';
   }
   else
   {
      echo '<script language="javascript">';
      echo 'alert("Error Occured - Ziyaretçi girişi")';
      echo '</script>';

   }
   	
}

/* Guest Exit */
	else if(isset($guestExit))
			{

        //Record guestExit event SQL
        $sqlExit = "UPDATE `cantas_ise`.`visitor` SET `exitTime` = str_to_date( '$exitTime', '%d/%m/%Y %H:%i') WHERE `visitor`.`id` = ( SELECT ID\n"
    . "FROM (\n"
    . "\n"
    . "SELECT id\n"
    . "FROM `cantas_ise`.`visitor` \n"
    . "WHERE `identityNum` ='$identityNumExit'\n"
    . "ORDER BY `entryTime` DESC \n"
    . "LIMIT 1\n"
    . ") AS x )";



    echo "$sqlExit";
    global $dbObj;
   if($dbObj->query($sqlExit) === TRUE )
   {
     echo '<script language="javascript">';
     echo 'alert("Ziyaretçi çıkışı kaydedildi.")';
     echo '</script>';
   }
   else
   {
      echo '<script language="javascript">';
      echo 'alert("Error Occured - Ziyaretçi çıkışı")';
      echo '</script>';
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

<script>/*
window.onerror = function(errorMsg) {
  $('#console').html($('#console').html()+'<br>'+errorMsg)
}*/
$('#datetimepicker').datetimepicker({
dayOfWeekStart : 1,
lang:'en',
disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
startDate:  '1986/01/05'
});
$('#datetimepicker').datetimepicker({value:'2015/04/15 05:03',step:10});

$('.some_class').datetimepicker();

$('#default_datetimepicker').datetimepicker({
  formatTime:'H:i',
  formatDate:'d.m.Y',
  defaultDate:'8.12.1986', // it's my birthday
  defaultTime:'10:00',
  timepickerScrollbar:false
});

$('#datetimepicker10').datetimepicker({
  step:5,
  inline:true
});
$('#datetimepicker_mask').datetimepicker({
  mask:'9999/19/39 29:59'
});

$('#datetimepicker1').datetimepicker({
  datepicker:false,
  format:'H:i',
  step:5
});
$('#datetimepicker2').datetimepicker({
  yearOffset:222,
  lang:'ch',
  timepicker:false,
  format:'d/m/Y',
  formatDate:'Y/m/d',
  minDate:'-1970/01/02', // yesterday is minimum date
  maxDate:'+1970/01/02' // and tommorow is maximum date calendar
});
$('#datetimepicker3').datetimepicker({
  inline:true
});
$('#datetimepicker4').datetimepicker();
$('#open').click(function(){
  $('#datetimepicker4').datetimepicker('show');
});
$('#close').click(function(){
  $('#datetimepicker4').datetimepicker('hide');
});
$('#reset').click(function(){
  $('#datetimepicker4').datetimepicker('reset');
});
$('#datetimepicker5').datetimepicker({
  datepicker:false,
  allowTimes:['12:00','13:00','15:00','17:00','17:05','17:20','19:00','20:00'],
  step:5
});
$('#datetimepicker6').datetimepicker();
$('#destroy').click(function(){
  if( $('#datetimepicker6').data('xdsoft_datetimepicker') ){
    $('#datetimepicker6').datetimepicker('destroy');
    this.value = 'create';
  }else{
    $('#datetimepicker6').datetimepicker();
    this.value = 'destroy';
  }
});
var logic = function( currentDateTime ){
  if( currentDateTime.getDay()==6 ){
    this.setOptions({
      minTime:'11:00'
    });
  }else
    this.setOptions({
      minTime:'8:00'
    });
};
$('#datetimepicker7').datetimepicker({
  format:'d/m/Y H:i',
  onChangeDateTime:logic,
  onShow:logic
});
$('#datetimepicker71').datetimepicker({
  format:'d/m/Y H:i',
  onChangeDateTime:logic,
  onShow:logic
});
$('#datetimepicker8').datetimepicker({format:'Y/m/d',
  onGenerate:function( ct ){
    $(this).find('.xdsoft_date')
      .toggleClass('xdsoft_disabled');
  },
  minDate:'-1970/01/2',
  maxDate:'+1970/01/2',
  timepicker:false
});
$('#datetimepicker9').datetimepicker({
  onGenerate:function( ct ){
    $(this).find('.xdsoft_date.xdsoft_weekend')
      .addClass('xdsoft_disabled');
  },
  weekends:['01.01.2014','02.01.2014','03.01.2014','04.01.2014','05.01.2014','06.01.2014'],
  timepicker:false
});
var dateToDisable = new Date();
  dateToDisable.setDate(dateToDisable.getDate() + 2);
$('#datetimepicker11').datetimepicker({
  beforeShowDay: function(date) {
    if (date.getMonth() == dateToDisable.getMonth() && date.getDate() == dateToDisable.getDate()) {
      return [false, ""]
    }

    return [true, ""];
  }
});
$('#datetimepicker12').datetimepicker({
  beforeShowDay: function(date) {
    if (date.getMonth() == dateToDisable.getMonth() && date.getDate() == dateToDisable.getDate()) {
      return [true, "custom-date-style"];
    }

    return [true, ""];
  }
});
$('#datetimepicker_dark').datetimepicker({theme:'dark'})


</script>


</body>

</html>