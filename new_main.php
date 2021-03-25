<!DOCTYPE html>
<html lang="en">
<head>
	<title>Indoors Simulations</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>

<?php
include './dbex/db_connect.php';
$conn = OpenCon();
$db = "simulationdb";

?>
<div style="display:flex; flex-direction: row; align-items: center;">
	<a href="new_main.php">
	<img src="drone.png" width="100" href="new_main.php"></a>

	<h1> Simulations scenarios</h1>
	
	<h2>Tables:&nbsp;&nbsp;</h2>

	<div class="pagination">
		<?php
		
		$slide = array_key_exists("table", $_GET) ? trim($_GET["table"]) : '';

		$result = mysqli_query($conn, "show tables");
		while($table = mysqli_fetch_array($result)) {
			if ($table[0] == $slide)
				echo("<a href=\"new_main.php?table=" . $table[0] . "\" class=\"active\">" . $table[0] . "</a>");
			else
				echo("<a href=\"new_main.php?table=" . $table[0] . "\">" . $table[0] . "</a>");
		}?>
	</div>
</div>

<?php
if ($slide != '')
{
	$sqlQuery = "SELECT `Id`, `ffk_bit`, `fa_bit`, `localization_bit`, `maphandler_bit`, `mcu_bit`, `pathplanner_bit`, `waypoint_bit`, 
	`wphandler_bit`, `mpc_bit`, `coverage_percentage`, `min_alt`, `avg_alt`, `max_alt`, `time_coverage_threshold`, `avg_vel_lin`, 
	`avg_vel_ang`, `scenario_time`, `ending_reason` , `stats` FROM " . $slide;
	$resultSet = mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));
	$resultSet2 = mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));
}
?>

<body>
	<table>
		<thead>
		<tr>
			<th>Id</th>
			<th>FFK Highest Bit</th>
			<th>FA H Bit</th>
			<th>Localization H Bit</th>
			<th>MapHandler H Bit</th>
			<th>Mcu H Bit</th>
			<th>PathPlanner H Bit</th>
			<th>WP H Bit</th>
			<th>WPHandler H Bit</th>
			<th>Mpc H Bit</th>
			<th>Coverage Percentage</th>
			<th>Min Altitude</th>
			<th>Avg Altitude</th>
			<th>Max Altitude</th>
			<th>Time Passed to Coverage Threshold</th>
			<th>Avg Velocity Linear</th>
			<th>Avg Velocity Angular</th>
			<th>Scenario Time</th>
			<th>Reason For Ending</th>
			<?php
				if ($slide == '')
					exit;
				$developer = mysqli_fetch_assoc($resultSet2);
				if ($developer['stats'] != '0'){
					$arr=unserialize($developer ['stats']);
					foreach ($arr as $key => $val) { ?>
						<th><?php echo $key; ?></th>
				<?php } }?>
		</tr>
		</thead>

		<tbody>
		<?php
		while( $developer = mysqli_fetch_assoc($resultSet) ) { ?>
			<?php
				echo "<td>" . $developer['Id'] . "</td>";
				echo "<td>" . $developer['ffk_bit'] . "</td>";
				echo "<td>" . $developer['fa_bit'] . "</td>";
				echo "<td>" . $developer['localization_bit'] . "</td>";
				echo "<td>" . $developer['maphandler_bit'] . "</td>";
				echo "<td>" . $developer['mcu_bit'] . "</td>";
				echo "<td>" . $developer['pathplanner_bit'] . "</td>";
				echo "<td>" . $developer['waypoint_bit'] . "</td>";
				echo "<td>" . $developer['wphandler_bit'] . "</td>";
				echo "<td>" . $developer['mpc_bit'] . "</td>";
				echo "<td>" . $developer['coverage_percentage'] . "</td>";
				echo "<td>" . $developer['min_alt'] . "</td>";
				echo "<td>" . $developer['avg_alt'] . "</td>";
				echo "<td>" . $developer['max_alt'] . "</td>";
				echo "<td>" . $developer['time_coverage_threshold'] . "</td>";
				echo "<td>" . $developer['avg_vel_lin'] . "</td>";
				echo "<td>" . $developer['avg_vel_ang'] . "</td>";
				echo "<td>" . $developer['scenario_time'] . "</td>";
				echo "<td>" . $developer['ending_reason'] . "</td>";
			if ($developer['stats'] != '0') {
				$arr2=unserialize($developer ['stats']);
				foreach ($arr2 as $key => $val) { ?>
					<td><?php echo $val; ?></td>
					<?php }
				}?>
		</tbody>
		<?php } ?>
	</table>

</body>
</html>
