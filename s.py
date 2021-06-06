import requests
import sys
url = 'http://127.0.0.1/filters_config.txt'

x = requests.get(url)

print(x.text)