// function duplicate() {
//     var original = document.getElementsByClassName('modal-content')[0];
//     var clone = original.cloneNode(true); // "deep" clone
//     original.parentNode.appendChild(clone);
// }



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

for (var key in exceptions)
{
    var field_btn = document.createElement("button")
    field_btn.className = "button"
    field_btn.innerHTML = key

    var modal_element = document.createElement("div")
    modal_element.className = "modal"
    modal_element.id = "modal " + key

    var modal_content = document.createElement("div")
    modal_content.className = "modal-content"
    modal_content.id = "modal content " + key
    
    var close_modal = document.createElement("span")
    close_modal.className = "close_modal"
    close_modal.id = "close modal " + key
    close_modal.innerHTML = "&times;"

    field_btn.onclick = function(btn) {
        modal_element = document.getElementById("modal " + btn.toElement.innerHTML)
        modal_element.style.display = "block"
    }
    
    close_modal.onclick = function() {
        modal_element.style.display = "none"
    }
    
    window.onclick = function(event) {
      if (event.target == modal_element) {
        modal_element.style.display = "none"
      }
    }

    for (var id of exceptions[key])
    {
        var id_elem = document.createElement("a")
        id_elem.href = "google.com"
        id_elem.text = id + " "
        modal_content.appendChild(id_elem)
    }

    document.getElementById("btn-group").appendChild(field_btn)
    modal_content.appendChild(close_modal)
    modal_element.appendChild(modal_content)
    document.body.appendChild(modal_element)
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