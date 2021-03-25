<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

include "db_connect.php"

$link = mysqli_connect("localhost", "elad", "Aa123456", "simulationdb");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
// Escape user inputs for security

$escapedGet = array_map(array($link, 'real_escape_string'), $_REQUEST);

// $Id = mysqli_real_escape_string($link, $_REQUEST['Id']);
// $ffk_bit = mysqli_real_escape_string($link, $_REQUEST['ffk_bit']);
// $fa_bit = mysqli_real_escape_string($link, $_REQUEST['fa_bit']);
// $localization_bit = mysqli_real_escape_string($link, $_REQUEST['localization_bit']);
// $maphandler_bit = mysqli_real_escape_string($link, $_REQUEST['maphandler_bit']);
// $mcu_bit = mysqli_real_escape_string($link, $_REQUEST['mcu_bit']);
// $pathplanner_bit = mysqli_real_escape_string($link, $_REQUEST['pathplanner_bit']);
// $waypoint_bit = mysqli_real_escape_string($link, $_REQUEST['waypoint_bit']);
// $wphandler_bit = mysqli_real_escape_string($link, $_REQUEST['wphandler_bit']);
// $mpc_bit = mysqli_real_escape_string($link, $_REQUEST['mpc_bit']);
// $coverage_percentage = mysqli_real_escape_string($link, $_REQUEST['coverage_percentage']);
// $min_alt = mysqli_real_escape_string($link, $_REQUEST['min_alt']);
// $avg_alt = mysqli_real_escape_string($link, $_REQUEST['avg_alt']);
// $max_alt = mysqli_real_escape_string($link, $_REQUEST['max_alt']);
// $time_coverage_threshold = mysqli_real_escape_string($link, $_REQUEST['time_coverage_threshold']);
// $avg_vel_lin = mysqli_real_escape_string($link, $_REQUEST['avg_vel_lin']);
// $avg_vel_ang = mysqli_real_escape_string($link, $_REQUEST['avg_vel_ang']);
// $scenario_time = mysqli_real_escape_string($link, $_REQUEST['scenario_time']);
// $ending_reason = mysqli_real_escape_string($link, $_REQUEST['ending_reason']);

// CHANGED TO THIS: (NOT SURE IF IT WORKS)
$values = []
for ($i = 0; $i < count($parameters); $i++)
    $values[] = mysqli_real_escape_string($link, $_POST[$parameters[$i]]);

foreach ($parameters as $param)
{
    unset($escapedGet[$param]);
}

extract($escapedGet);
if (empty($escapedGet)) {
    echo "No stats key value was received";
    // $sql = "INSERT INTO `lab1` (`Id`, `ffk_bit`, `fa_bit`, `localization_bit`, `maphandler_bit`, `mcu_bit`, `pathplanner_bit`, `waypoint_bit`, 
    // `wphandler_bit`, `mpc_bit`, `coverage_percentage`, `min_alt`, `avg_alt`, `max_alt`, `time_coverage_threshold`, `avg_vel_lin`, 
    // `avg_vel_ang`, `scenario_time`, `ending_reason` , `stats`) VALUES ('$Id', '$ffk_bit', '$fa_bit', '$localization_bit', '$maphandler_bit', '$mcu_bit', 
    // '$pathplanner_bit', '$waypoint_bit', '$wphandler_bit', '$mpc_bit', '$coverage_percentage', '$min_alt', 
    // '$avg_alt', '$max_alt', '$time_coverage_threshold', '$avg_vel_lin', '$avg_vel_ang', '$scenario_time', 
    // '$ending_reason' , '')";

    // SAME
    $sql = "INSERT INTO lab1 (" . implode(', ', $parameters) . ", stats) VALUES (" . implode(', ', $values) . ", '')";
}
else
{
    $stats = serialize($escapedGet);
    // Attempt insert query execution
    // change ID to NULL in order to auto incerment

    // $sql = "INSERT INTO `lab1` (`Id`, `ffk_bit`, `fa_bit`, `localization_bit`, `maphandler_bit`, `mcu_bit`, `pathplanner_bit`, `waypoint_bit`, 
    // `wphandler_bit`, `mpc_bit`, `coverage_percentage`, `min_alt`, `avg_alt`, `max_alt`, `time_coverage_threshold`, `avg_vel_lin`, 
    // `avg_vel_ang`, `scenario_time`, `ending_reason` , `stats`) VALUES ('$Id', '$ffk_bit', '$fa_bit', '$localization_bit', '$maphandler_bit', '$mcu_bit', 
    // '$pathplanner_bit', '$waypoint_bit', '$wphandler_bit', '$mpc_bit', '$coverage_percentage', '$min_alt', 
    // '$avg_alt', '$max_alt', '$time_coverage_threshold', '$avg_vel_lin', '$avg_vel_ang', '$scenario_time', 
    // '$ending_reason' , '$stats')";

    // SAME
    $sql = "INSERT INTO lab1 (" . implode(', ', $parameters) . ", stats) VALUES (" . implode(', ', $values) . ", $stats)";
}
if(mysqli_query($link, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>