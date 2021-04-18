var BIG_NUM = 99999;
var table = document.getElementById("table");
var row_len = table.rows[4].cells.length;

var min = new Array(row_len).fill(BIG_NUM), max = new Array(row_len).fill(0), sum = new Array(row_len).fill(0);
for (var i = 0, row; row = table.rows[i]; i++)
{
    for (var j = 1, cell; cell = row.cells[j]; j++)
    {
        if (isNaN(parseFloat(cell.innerHTML)))
            continue;
        var val = parseFloat(cell.innerHTML);

        if (j < 10) // bit cells
        {
            if (val == 1)
                cell.style.background = "#eff542";
            else if (val == 2)
                cell.style.background = "#f55742";
        }

        if (val < min[j])
            min[j] = val;

        if (val > max[j])
            max[j] = val;

        sum[j] += val;
    }
}

for (var i = 1; i < row_len; i++)
{
    if (isNaN(parseFloat(table.rows[4].cells[i].innerHTML)))
    {
        var rows = ["min", "max", "avg"];
        rows.forEach(function(entry) {
            var node = document.createElement("td");
            node.innerHTML = "";
            document.getElementById(entry).appendChild(node);
        });
        continue;
    }
    if (min[i] == BIG_NUM)
        continue;
    var node = document.createElement("td");
    node.innerHTML = min[i];
    document.getElementById("min").appendChild(node);

    var node = document.createElement("td");
    node.innerHTML = max[i];
    document.getElementById("max").appendChild(node);
    
    var node = document.createElement("td");
    if (i < 10)
        node.innerHTML = "";
    else
        node.innerHTML = (sum[i] / (table.rows.length - 4)).toFixed(2);
    document.getElementById("avg").appendChild(node);
}

function removeColumn(index) {
    for (var i = 0, row; row = table.rows[i]; i++)
    {
        row.deleteCell(index);
    }
}

for (var j = 1, cell; cell = table.rows[3].cells[j]; j++)
{
    var button = document.createElement("button");
    button.innerHTML = "remove";
    button.addEventListener("click", function (e) {
        removeColumn(e.toElement.parentElement.cellIndex);
    })
    cell.appendChild(document.createElement("br"))
    cell.appendChild(button)
}