<?php
session_start();
include_once("dbconnect.php");

function login($un, $pw) {
    global $dbObj;

    $sql = "select * from users where username='$un' and password='$pw'";
    $result = $dbObj->query($sql);
    $numrow = $dbObj->size($result);
    if ($numrow >= 1) {
        $rec = $dbObj->fetchAssoc($result);
        $_SESSION["authenticate"] = "OK";
        $_SESSION["uid"] = $rec["userid"];
        $_SESSION["fname"] = $rec["fname"];
        $_SESSION["lname"] = $rec["lname"];
        $_SESSION["utype"] = $rec["usertype"];
        return $rec["usertype"];
		
    }
    return 0;
}

function checkautheticatedUser($type) {
    if (!isset($_SESSION["authenticate"]) || $_SESSION["authenticate"] != "OK") {
        return 0;
    } 
    else if($_SESSION["utype"] != $type)
        return 0;
    else
        return  1;
    
}

function display_userInfo(){
     echo "<img src='images/users/".$_SESSION["uid"].".jpg'>";
     echo $_SESSION["uname"] . " " . $_SESSION["usurname"];  
}
?>