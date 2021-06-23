function doesFileExist(urlToFile) {
    var xhr = new XMLHttpRequest();
    xhr.open('HEAD', urlToFile, false);
    xhr.send();

    return xhr.status !== 404;
}

function getTable() {

    var uri = window.location.toString()
    var url = new URL(uri)
    var params = new URLSearchParams(url.search)

    const http = new XMLHttpRequest()
    var str_url = 'index.php?' + params.toString()
    http.open("GET", str_url, false)
    http.send(null)

    var doc = new DOMParser().parseFromString(http.responseText, "text/html")
    var table = doc.getElementById('table')
    return [table, params.get('table')]
}


var [table, table_name] = getTable()

// {<column index>: [<column name>, <BIT/ALIVE>]}
var relevant_fields = {}

// {<column name>: <array of exceptions id>}
var exceptions = {};

// the exception of every field
const BIT = 2,
    ALIVE = 0;

// iterating only the fields name (line 4)
for (var j = 1, cell; cell = table.rows[4].cells[j]; j++) {
    if (cell.innerHTML.includes(" bit"))
        relevant_fields[j] = [cell.innerHTML, BIT]
    else if (cell.innerHTML.includes(" alive"))
        relevant_fields[j] = [cell.innerHTML, ALIVE]
}

// iterating relevant_fields (BIT or ALIVE fields) to find exceptional simulations in every column
for (var key in relevant_fields) {
    for (var i = 4, row; row = table.rows[i]; i++) {
        // if the value is exceptional and it's alive field or bit field
        if (parseInt(row.cells[key].innerHTML) === relevant_fields[key][1] && (relevant_fields[key][1] === BIT || relevant_fields[key][1] === ALIVE)) {
            var val = parseInt(table.rows[i].cells[0].childNodes[0].innerHTML)
            if (relevant_fields[key][0] in exceptions)
                exceptions[relevant_fields[key][0]].push(val)
            else
                exceptions[relevant_fields[key][0]] = [val]
        }
    }
}

// creating a modal (pop up) with all the exceptions (2/0) for every BIT/ALIVE field
for (var key in exceptions) {
    var field_btn = document.createElement("button")
    field_btn.className = "button"
    field_btn.innerHTML = key

    var modal_element = document.createElement("div")
    modal_element.className = "modal"
    modal_element.id = "modal " + key


    // TODO: fix the arrangement
    var modal_content = document.createElement("div")
    modal_content.className = "modal-content"
    modal_content.id = "modal content " + key

    var close_modal = document.createElement("span")
    close_modal.className = "close_modal"
    close_modal.id = "close modal " + key
    close_modal.innerHTML = "&times;" // x sign

    field_btn.onclick = function(btn) {
        modal_element = document.getElementById("modal " + btn.toElement.innerHTML)
        modal_element.style.display = "block"
    }

    close_modal.onclick = function() {
        modal_element.style.display = "none"
    }

    // click outside the modal
    window.onclick = function(event) {
        if (event.target == modal_element) {
            modal_element.style.display = "none"
        }
    }

    var count = 0;
    // in the modal, creating link for every exceptional simulation
    for (var id of exceptions[key]) {
        var id_elem = document.createElement("a")
        id_elem.href = 'http://10.42.149.53:5000/' + table_name + '/' + id
        id_elem.target = "_blank"
        id_elem.className = "sim-btn"
        id_elem.innerHTML = id
        modal_content.appendChild(id_elem)
        count++;
        if (count % 20 == 0)
            modal_content.innerHTML += "<br><br>"
    }

    modal_content.appendChild(close_modal)
    document.getElementById("btn-group").appendChild(field_btn)
    modal_element.appendChild(modal_content)
    document.body.appendChild(modal_element)
}