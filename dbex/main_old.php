<?php 
include 'header.php';
?>
<title>Indoors Simulations </title>

<style>
table {
    background-color: #181818;
}
table, .table {
    color: #fff;
}
</style>
<div class="container">	
	<div class="row">
		<h2>Simulation Scenarios </h2>	
<?php
include 'db_connect.php';
$conn = OpenCon();
// echo "Connected Successfully";

$sqlQuery = "SELECT `Id`, `ffk_bit`, `fa_bit`, `localization_bit`, `maphandler_bit`, `mcu_bit`, `pathplanner_bit`, `waypoint_bit`, 
`wphandler_bit`, `mpc_bit`, `coverage_percentage`, `min_alt`, `avg_alt`, `max_alt`, `time_coverage_threshold`, `avg_vel_lin`, 
`avg_vel_ang`, `scenario_time`, `ending_reason` FROM lab1 LIMIT 19";
$resultSet = mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));


#CloseCon($conn);
?>


<table id="editableTable" class="table table-bordered">
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
		</tr>
	</thead>
	<tbody>
		<?php while( $developer = mysqli_fetch_assoc($resultSet) ) { ?>
		   <tr id="<?php echo $developer ['Id']; ?>">
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
		   </tr>
		<?php } ?>
	</tbody>
</table>
	</div>
</div>
<?php include 'footer.php';?>
