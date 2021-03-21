#!/usr/bin/python
import sys
# print(sys.argv[2:]);
myobj = {'ID': sys.argv[1]} 
arr = []
arr = sys.argv[2:]
print arr
for i in range(0, len(arr), 2):
    myobj[arr[i]] = arr[i+1]
print myobj