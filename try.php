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
						<td><?php echo $val; ?></td>
						<?php }
					}?>
		</tbody>
		<?php } ?>