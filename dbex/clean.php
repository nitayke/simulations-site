<?php

include 'db_connect.php';

$conn = OpenCon();

// sql to create table
$sql = "DELETE FROM `" . $_POST["table_name"] . "`";

if (mysqli_query($conn, $sql)) {
  echo "Table cleaned successfully";
} else {
  echo "Error cleaning table: " . mysqli_error($conn);
}

mysqli_close($conn);

?>