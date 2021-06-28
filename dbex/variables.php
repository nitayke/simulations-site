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
"PARAMS_NOT_LOADED",
"System_Couldnt_calculate_OUTDOOR",
"System_Didnt_succeed_to_Rotate",
"System_Didnt_succeed_to_Manual_move",
"System_Didnt_move_to_POINT_AND_GO",
"System_Didnt_recieved_POINT_AND_GO_IMAGE",
"Finished_POINT_AND_GO_without_success_moved_to_HOLDING_POSITION",
"Finished_POINT_AND_GO_with_success_moved_to_HOLDING_POSITION",
"Didnt_catch_reason"];

?>
