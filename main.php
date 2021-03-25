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

$sqlQuery = "SELECT `Id`, `ffk_bit`, `fa_bit`, `localization_bit`, `maphandler_bit`, `mcu_bit`, `pathplanner_bit`, `waypoint_bit`, 
`wphandler_bit`, `mpc_bit`, `coverage_percentage`, `min_alt`, `avg_alt`, `max_alt`, `time_coverage_threshold`, `avg_vel_lin`, 
`avg_vel_ang`, `scenario_time`, `ending_reason` , `stats` FROM lab1";
$resultSet = mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));
$resultSet2 = mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));

?>
<div style="display:flex; flex-direction: row; align-items: center;">
	<h1> Simulations scenarios </h1>

	<p>Navigation pagination:</p>
	<div class="pagination" >
		<?php
	$result = mysqli_query($conn, "show tables");
	while($table = mysqli_fetch_array($result)) {
		?> <a href="#"> <?php echo($table[0] . "</a>");
	}?>
	</div>
</div>

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
				$developer = mysqli_fetch_assoc($resultSet2);
				if ($developer['stats'] != '0'){
					$arr=unserialize($developer ['stats']);
					foreach ($arr as $key => $val) { ?>
						<th><?php echo $key; ?></th>
				<?php } }?>
		</tr>
				</thead>
				<tbody>
			<?php while( $developer = mysqli_fetch_assoc($resultSet) ) { ?>
				<td><?php echo $developer ['Id']; ?></td>
				<td><?php echo $developer ['ffk_bit']; ?></td>
				<td><?php echo $developer ['fa_bit']; ?></td>
				<td><?php echo $developer ['localization_bit']; ?></td>
				<td><?php echo $developer ['maphandler_bit']; ?></td>
				<td><?php echo $developer ['mcu_bit']; ?></td>
				<td><?php echo $developer ['pathplanner_bit']; ?></td>
				<td><?php echo $developer ['waypoint_bit']; ?></td>
				<td><?php echo $developer ['wphandler_bit']; ?></td>
				<td><?php echo $developer ['mpc_bit']; ?></td>
				<td><?php echo $developer ['coverage_percentage']; ?></td>
				<td><?php echo $developer ['min_alt']; ?></td>
				<td><?php echo $developer ['avg_alt']; ?></td>
				<td><?php echo $developer ['max_alt']; ?></td>
				<td><?php echo $developer ['time_coverage_threshold']; ?></td>
				<td><?php echo $developer ['avg_vel_lin']; ?></td>
				<td><?php echo $developer ['avg_vel_ang']; ?></td>
				<td><?php echo $developer ['scenario_time']; ?></td>
				<td><?php echo $developer ['ending_reason']; ?></td>
				<?php
				if ($developer['stats'] != '0') {
					$arr2=unserialize($developer ['stats']);
					foreach ($arr2 as $key => $val) { ?>
						<td><?php echo $val; ?></th>
						<?php }
					}?>
					</tbody>	   				   
			</tr>
			<?php } ?>
	</table>

</body>
</html>
