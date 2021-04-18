import requests
import sys
url = 'http://localhost/dbex/insert.php'

if len(sys.argv) != 2:
    print "Usage: python post_try.py <id>"
    exit()

myobj = {'batch_name': 'test2', 'Id': sys.argv[1], 'ffk_bit': '0', 'fa_bit':'0', 'localization_bit':'0', 'maphandler_bit':'0', 'mcu_bit':'0', 'pathplanner_bit':'0', 'waypoint_bit':'0', 
'wphandler_bit':'0', 'mpc_bit':'0', 'coverage_percentage':'0', 'min_alt':'0', 'avg_alt':'0', 'max_alt':'0', 'time_coverage_threshold':'0', 'avg_vel_lin':'0', 
'avg_vel_ang':'0', 'scenario_time':'0', 'ending_reason':'no_reason', 'nop': '1', 'abc': '0'}
x = requests.post(url, data = myobj)

print(x.text)