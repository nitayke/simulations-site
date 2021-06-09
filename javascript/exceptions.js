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

// {<column>: [<column name>, <BIT/ALIVE>]}
var relevant_fields = {}
// {<column name>: <array of exceptions id>}
var exceptions = {}
const BIT = 2, ALIVE = 0;

for (var j = 1, cell; cell = table.rows[4].cells[j]; j++)
{
    if (cell.innerHTML.includes(" bit"))
        relevant_fields[j]= [cell.innerHTML, BIT]
    else if (cell.innerHTML.includes(" alive"))
        relevant_fields[j]= [cell.innerHTML, ALIVE]
}

for (var key in relevant_fields)
{
    for (var i = 4, row; row = table.rows[i]; i++)
    {
        // if the value is exceptional and it's alive field or bit field
        if (parseInt(row.cells[key].innerHTML) === relevant_fields[key][1] && (relevant_fields[key][1] === BIT || relevant_fields[key][1] === ALIVE))
        {
            var val = parseInt(table.rows[i].cells[0].innerHTML)
            if (relevant_fields[key][0] in exceptions)
                exceptions[relevant_fields[key][0]].push(val)
            else
                exceptions[relevant_fields[key][0]] = [val]
        }
    }
}

console.log(exceptions)

for (var key in exceptions)
{
    var elem = document.createElement("button")
    elem.className = "button"
    elem.innerHTML = key

    elem.onclick = function() {
        modal.style.display = "block";
    }

    document.getElementById("btn-group").appendChild(elem)
}



// Get the modal
var modal = document.getElementById("modal");

// Get the <span> element that closes the modal
var close_modal = document.getElementById("close_modal")

// When the user clicks on <span> (x), close the modal
close_modal.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

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