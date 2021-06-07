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

$ending_reasons = ["System_Failure",
"User_Request",
"System_Timeout",
"System_Didnt_move_to_Exploration",
"System_Didnt_move_to_TakeOff",
"System_Didnt_move_to_INDOOR",
"System_Didnt_move_to_ARM",
"System_Didnt_move_to_WIFI",
"Finished_Exploration_moved_to__HOLDING_POSITION",
"Didnt_catch_reason"];

?>