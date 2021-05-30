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

function set_num_cols()
{
    let val = document.getElementById("number_of_columns").value;
    setParam('cols', val)
}

var uri = window.location.toString()
var url = new URL(uri)
var params = new URLSearchParams(url.search)

const http = new XMLHttpRequest()
url = 'index.php?' + params.toString()
http.open("GET", url, false)
http.send(null)


var doc = new DOMParser().parseFromString(http.responseText, "text/html")
var table = doc.getElementById('table')
param = params.get('param')

var index = -1

for (var i = 0, row; row = table.rows[i]; i++)
{
    for (var j = 1, cell; cell = row.cells[j]; j++)
    {
        if (i === 4 && cell.innerHTML === param.replaceAll('_', ' '))
            index = j
    }
    if (index !== -1)
        break
}

var all_numbers = []
for (var i = 0, row; row = table.rows[i]; i++)
{
    if (row.cells[index] === undefined)
        continue
    const parsed = parseInt(row.cells[index].innerHTML)
    if (!isNaN(parsed))
        all_numbers.push(parsed)
}
console.log(all_numbers)

var min = Math.min.apply(null, all_numbers)
var max = Math.max.apply(null, all_numbers)

const NUM_OF_COLS = params.get('cols')
var graph_x = []
var graph_y = []

for (var i = 0; i < NUM_OF_COLS; i++)
{
    graph_x.push((max-min)*i/NUM_OF_COLS + min)
    var sum = 0
    for (var j = 0; j < all_numbers.length; j++)
    {
        if (graph_x[i-1] < all_numbers[j] && graph_x[i] > all_numbers[j])
            sum++;
    }
    graph_y.push(sum)
}
console.log(graph_x)
console.log(graph_y)

document.getElementById("num_col_btn").addEventListener("click", set_num_cols);