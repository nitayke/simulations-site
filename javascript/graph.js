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
var param = params.get('param')

const http = new XMLHttpRequest()
url = 'index.php?' + params.toString()
http.open("GET", url, false)
http.send(null)


var doc = new DOMParser().parseFromString(http.responseText, "text/html")
var table = doc.getElementById('table')

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
var good = []
var bad = []

for (var i = 0, row; row = table.rows[i]; i++)
{
    if (row.cells[index] === undefined)
        continue
    const parsed = parseFloat(row.cells[index].innerHTML)
    if (!isNaN(parsed))
        all_numbers.push(parsed)
    if (row.cells[0].style.background === "rgb(69, 255, 153)")
        good.push(parsed)
    else
        bad.push(parsed)
}

var min = Math.min.apply(null, all_numbers)
var max = Math.max.apply(null, all_numbers)

var NUM_OF_COLS = params.get('cols')
if (!NUM_OF_COLS)
    NUM_OF_COLS = 20;
var graph_x = []
var graph_y = []

var good_x = []
var good_y = []

var bad_x = []
var bad_y = []

for (var i = 0; i < NUM_OF_COLS; i++)
{
    graph_x.push((max-min)*i/NUM_OF_COLS + min)
    good_x.push((max-min)*i/NUM_OF_COLS + min)
    bad_x.push((max-min)*i/NUM_OF_COLS + min)
    var sum = 0
    var good_sum = 0
    var bad_sum = 0
    for (var j = 0; j < all_numbers.length; j++)
    {
        if (graph_x[i-1] < all_numbers[j] && graph_x[i] > all_numbers[j])
            sum++;
    }
    for (var j = 0; j < good.length; j++)
    {
        if (good_x[i-1] < good[j] && good_x[i] > good[j])
            good_sum++;
    }
    for (var j = 0; j < bad.length; j++)
    {
        if (bad_x[i-1] < bad[j] && bad_x[i] > bad[j])
            bad_sum++;
    }
    graph_y.push(sum)
    good_y.push(good_sum)
    bad_y.push(bad_sum)
}

document.getElementById("num_col_btn").addEventListener("click", set_num_cols);