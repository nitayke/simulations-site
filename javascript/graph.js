// Used in the function set_range.
function setParam(key, value) {
    let url = new URL(window.document.location);
    let params = new URLSearchParams(url.search.slice(1));

    if (params.has(key)) {
        params.set(key, value);
    } else {
        params.append(key, value);
    }
    window.location.href = url.origin + url.pathname + '?' + params.toString();
}

function set_range() {
    let val = document.getElementById("number_of_columns").value;
    setParam('range', val)
}



var uri = window.location.toString()
var url = new URL(uri)
var params = new URLSearchParams(url.search)
var param = params.get('param')

const http = new XMLHttpRequest()
url = 'index.php?' + params.toString()
http.open("GET", url, false)
http.send(null)


var doc = new DOMParser().parseFromString(http.responseText, "text/html")
var table = doc.getElementById('table')

var index = -1

// Finding the index of the chosen field
for (var j = 1, cell; cell = table.rows[4].cells[j]; j++) {
    if (cell.innerHTML === param.replaceAll('_', ' '))
        index = j
}

var all_numbers = []
var good = []
var bad = []

// Filling the arrays: all_numbers, good, and bad.
for (var i = 0, row; row = table.rows[i]; i++) {
    if (row.cells[index] === undefined)
        continue
    const parsed = parseFloat(row.cells[index].innerHTML)
    if (!isNaN(parsed))
        all_numbers.push(parsed)
    if (row.cells[0].style.background === "rgb(69, 255, 153)") // If the background color is green, add it to 'good' array
        good.push(parsed)
    else
        bad.push(parsed) // If it's red
}

var min = Math.min.apply(null, all_numbers)
var max = Math.max.apply(null, all_numbers)

var RANGE = params.get('range')
if (!RANGE)
    RANGE = 10;
var graph_x = []
var graph_y = []

var good_x = []
var good_y = []

var bad_x = []
var bad_y = []

// max/RANGE is the number of columns in the graph.
for (var i = 0; i < Math.ceil(max / RANGE) + 3; i++) {
    // all of the graphs has the same x points
    var x_value = min + (max - min) * i / (max / RANGE)
    graph_x.push(x_value)
    good_x.push(x_value)
    bad_x.push(x_value)

    var sum = 0
    var good_sum = 0
    var bad_sum = 0

    // sum = count of the values which are between two x points.
    // for example, scenario time is 0 < x < 360, so if the range is 10,
    // we iterate 36 times and check every time if the value is between
    // 0-10, 10-20, etc.
    for (var j = 0; j < all_numbers.length; j++) {
        if (graph_x[i - 1] < all_numbers[j] && graph_x[i] > all_numbers[j])
            sum++;
    }
    for (var j = 0; j < good.length; j++) {
        if (good_x[i - 1] < good[j] && good_x[i] > good[j])
            good_sum++;
    }
    for (var j = 0; j < bad.length; j++) {
        if (bad_x[i - 1] < bad[j] && bad_x[i] > bad[j])
            bad_sum++;
    }
    graph_y.push(sum)
    good_y.push(good_sum)
    bad_y.push(bad_sum)
}

document.getElementById("num_col_btn").addEventListener("click", set_range);