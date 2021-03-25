import requests
import sys
import yaml

url = 'http://192.168.2.138/dbex/insert.php'

if len(sys.argv) != 4:
    print "Usage: python post.py <scenario_id> <yaml_file_path> <table_name>"
    exit()

params = {}
with open(sys.argv[2], 'r') as stream:
    try:
        params = yaml.safe_load(stream)
    except yaml.YAMLError as exc:
        print(exc)
        exit(1)

params['Id'] = sys.argv[1]
params['table_name'] = sys.argv[2]

arr = sys.argv[len(params)+1:]
if len(arr)%2!=0:
    print "The added key values do not devide in 2 "
if len(arr) > 1 and len(arr)%2==0:
    for i in range(0, len(arr), 2):
        params[arr[i]] = arr[i+1]

print params

x = requests.post(url, data=params)

print x.content