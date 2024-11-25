<?php
ini_set("display_errors","on");
if(!isset($dbh)){
 session_start();
 date_default_timezone_set("UTC"); // Set Time Zone
 $host = "127.0.0.1"; // Hostname
 $port = "3306"; // MySQL Port : Default : 3306
 $user = "development"; // Username Here
 $pass = "!upZlv2i27Sk7LsHCdev"; //Password Here
 $db   = "practicle"; // Database Name
 $dbh  = new PDO('mysql:dbname='.$db.';host='.$host.';port='.$port,$user,$pass);
 
 /*Change The Credentials to connect to database.*/
 include("user_online.php");
}
?>
