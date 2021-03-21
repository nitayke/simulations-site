import requests
import sys
url = 'http://localhost/dbex/insert.php'
# myobj = {'Id':'5', 
#         'bit_number':'34', 
#         'sim_time':'344', 
#         'reason_for_ending':'shum davar'} 
myobj = {'Id': sys.argv[1], 'ffk_bit': '0', 'fa_bit':'0', 'localization_bit':'0', 'maphandler_bit':'0', 'mcu_bit':'0', 'pathplanner_bit':'0', 'waypoint_bit':'0', 
'wphandler_bit':'0', 'mpc_bit':'0', 'coverage_percentage':'0', 'min_alt':'0', 'avg_alt':'0', 'max_alt':'0', 'time_coverage_threshold':'0', 'avg_vel_lin':'0', 
'avg_vel_ang':'0', 'scenario_time':'0', 'ending_reason':'no_reason', 'stats':'0'}
x = requests.post(url, data = myobj)

print(x.text)
