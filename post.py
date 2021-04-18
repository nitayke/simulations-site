import requests
import sys
url = 'http://192.168.2.138/dbex/insert.php'

myobj = {'Id': sys.argv[1], 'ffk_bit': sys.argv[2], 'fa_bit':sys.argv[3], 'localization_bit':sys.argv[4], 
'maphandler_bit':sys.argv[5], 'mcu_bit':sys.argv[6], 'pathplanner_bit':sys.argv[7], 'waypoint_bit':sys.argv[8], 
'wphandler_bit':sys.argv[9], 'mpc_bit':sys.argv[10], 'coverage_percentage':sys.argv[11], 
'min_alt':sys.argv[12], 'avg_alt':sys.argv[13], 'max_alt':sys.argv[14], 
'time_coverage_threshold':sys.argv[15], 'avg_vel_lin':sys.argv[16], 
'avg_vel_ang':sys.argv[17], 'scenario_time':sys.argv[18], 'ending_reason':sys.argv[19]}

arr = sys.argv[len(myobj)+1:]
if len(arr)%2!=0:
    print "The added key values do not devide in 2 "
if len(arr) > 1 and len(arr)%2==0:
    for i in range(0, len(arr), 2):
        myobj[arr[i]] = arr[i+1]
# print myobj
x = requests.post(url, data = myobj)

print(x.text)