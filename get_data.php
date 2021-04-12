<?php
include './dbex/db_connect.php';

$conn = OpenCon();

$slide = array_key_exists("table", $_GET) ? trim($_GET["table"]) : '';

$result = mysqli_query($conn, "show tables");
if ($slide == '')
    $slide = mysqli_fetch_array($result)[0];
$sqlQuery = "SELECT * FROM " . $slide;

$resultSet = mysqli_query($conn, $sqlQuery) or die("<br>database error: ". mysqli_error($conn));


$path = "./table.csv";

$myfile = fopen($path, "w");

$developer = mysqli_fetch_assoc($resultSet);
if ($developer['stats'] != '' && $developer['stats'] != '0') {
    $arr=unserialize($developer ['stats']);
	array_pop($developer);
	foreach ($arr as $key => $val){
		$developer[$key] = $val;
	}
}
else
	array_pop($developer);

?>