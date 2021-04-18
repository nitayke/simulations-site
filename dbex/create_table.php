<?php

include 'db_connect.php';

$conn = OpenCon();

// sql to create table
$sql = "CREATE TABLE `" . $_POST['table_name'] . "` (
    Id int(6) AUTO_INCREMENT PRIMARY KEY,
    ffk_bit int(6),
    fa_bit int(6),
    localization_bit int(6),
    maphandler_bit int(6),
    mcu_bit int(6),
    pathplanner_bit int(6),
    waypoint_bit int(6),
    wphandler_bit int(6),
    mpc_bit int(6),
    coverage_percentage int(6),
    min_alt float(6),
    avg_alt float(6),
    max_alt float(6),
    time_coverage_threshold float(6),
    avg_vel_lin float(6),
    avg_vel_ang float(6),
    scenario_time int(6),
    ending_reason varchar(100),
    stats longblob )";

if (mysqli_query($conn, $sql)) {
  echo "Table created successfully";
} else {
  echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);

?>