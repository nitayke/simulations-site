<?php
$parameters = ['Id',
'ffk_bit',
'fa_bit',
'localization_bit',
'maphandler_bit',
'mcu_bit',
'pathplanner_bit',
'waypoint_bit',
'wphandler_bit',
'mpc_bit',
'coverage_percentage',
'min_alt',
'avg_alt',
'max_alt',
'time_coverage_threshold',
'avg_vel_lin',
'avg_vel_ang',
'scenario_time',
'ending_reason'];

$operators = ['==', '!=', '>', '<', '>=', '<='];

$operators_sql = ["==" => "=", "!=" => "<>"];

?>