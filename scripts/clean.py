import requests
import sys
url = 'http://192.168.2.138/dbex/clean.php'

if len(sys.argv) != 2:
    print "Usage: 'python clean.py <table_name>"
    exit()
myobj = {'table_name': sys.argv[1]}

x = requests.post(url, data = myobj)

print(x.text)