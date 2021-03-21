<?php
function OpenCon()
 {
 $dbhost = "localhost";
 $dbuser = "elad";
 $dbpass = "Aa123456";
 $db = "simulationdb";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
 
 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
   
 ?>