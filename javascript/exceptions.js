var uri = window.location.toString()
var url = new URL(uri)
var params = new URLSearchParams(url.search)
param = params.get('param')

const http = new XMLHttpRequest()
url = 'index.php?' + params.toString()
http.open("GET", url, false)
http.send(null)


var doc = new DOMParser().parseFromString(http.responseText, "text/html")
var table = doc.getElementById('table');

/*
iterate the table 
find bit and alive fields
iterate them
find in every field the id of the exceptions
show them with buttons to download
download:
    ssh in php - copy from lambda to web server
    copy them to the web server
    download from the site to a client computer
*/