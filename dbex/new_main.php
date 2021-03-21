<!DOCTYPE html>
<html lang="en">
<head>
	<title>Table V01</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<?php
include './dbex/db_connect.php';
$conn = OpenCon();
// echo "Connected Successfully";

$sqlQuery = "SELECT `Id`, `ffk_bit`, `fa_bit`, `localization_bit`, `maphandler_bit`, `mcu_bit`, `pathplanner_bit`, `waypoint_bit`, 
`wphandler_bit`, `mpc_bit`, `coverage_percentage`, `min_alt`, `avg_alt`, `max_alt`, `time_coverage_threshold`, `avg_vel_lin`, 
`avg_vel_ang`, `scenario_time`, `ending_reason` FROM lab1 LIMIT 19";
$resultSet = mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));


#CloseCon($conn);
?>
<body>
	
	<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
				<div class="table100">
					<table>
						<thead>
							<tr class="table100-head">
								<th class="column1">Id</th>
								<th class="column2">FFK Highest Bit</th>
								<th class="column3">FA H Bit</th>
								<th class="column4">Localization H Bit</th>
								<th class="column5">MapHandler H Bit</th>
								<th class="column6">Mcu H Bit</th>
								<th class="column7">PathPlanner H Bit</th>
								<th class="column8">WP H Bit</th>
								<th class="column9">WPHandler H Bit</th>
								<th class="column10">Mpc H Bit</th>
								<th class="column11">Coverage Percentage</th>
								<th class="column12">Min Altitude</th>
								<th class="column13">Avg Altitude</th>
								<th class="column14">Max Altitude</th>
								<th class="column15">Time Passed to Coverage Threshold</th>
								<th class="column16">Avg Velocity Linear</th>
								<th class="column17">Avg Velocity Angular</th>
								<th class="column18">Scenario Time</th>
								<th class="column19">Reason For Ending</th>
							</tr>
						</thead>
						<tbody>
								<!-- <tr>
									<td class="column1">2017-09-29 01:22</td>
									<td class="column2">200398</td>
									<td class="column3">iPhone X 64Gb Grey</td>
									<td class="column4">$999.00</td>
									<td class="column5">1</td>
									<td class="column6">$999.00</td>
								</tr> -->
								<?php while( $developer = mysqli_fetch_assoc($resultSet) ) { ?>
								<tr>
								<td class="column1"><?php echo $developer ['Id']; ?></td>
								<td class="column2"><?php echo $developer ['ffk_bit']; ?></td>
								<td class="column3"><?php echo $developer ['fa_bit']; ?></td>
								<td class="column4"><?php echo $developer ['localization_bit']; ?></td>
								<td class="column5"><?php echo $developer ['maphandler_bit']; ?></td>
								<td class="column6"><?php echo $developer ['mcu_bit']; ?></td>
								<td class="column7"><?php echo $developer ['pathplanner_bit']; ?></td>
								<td class="column8"><?php echo $developer ['waypoint_bit']; ?></td>
								<td class="column9"><?php echo $developer ['wphandler_bit']; ?></td>
								<td class="column10"><?php echo $developer ['mpc_bit']; ?></td>
								<td class="column11"><?php echo $developer ['coverage_percentage']; ?></td>
								<td class="column12"><?php echo $developer ['min_alt']; ?></td>
								<td class="column13"><?php echo $developer ['avg_alt']; ?></td>
								<td class="column14"><?php echo $developer ['max_alt']; ?></td>
								<td class="column15"><?php echo $developer ['time_coverage_threshold']; ?></td>
								<td class="column16"><?php echo $developer ['avg_vel_lin']; ?></td>
								<td class="column17"><?php echo $developer ['avg_vel_ang']; ?></td>
								<td class="column18"><?php echo $developer ['scenario_time']; ?></td>
								<td class="column19"><?php echo $developer ['ending_reason']; ?></td> 				   				   				  
								</tr>
								<?php } ?>
								
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>


	

<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>