// This file is for the min-max-avg and bit-cells colors.

var BIG_NUM = 9999999999;
var table = document.getElementById("table");
// If the table is empty
if (table.rows.length === 5)
    document.getElementById("loader").hidden = true;
// Here the code is supposed to crash if the table is empty because the length of rows is only 5.
var row_len = table.rows[5].cells.length;

var min = new Array(row_len).fill(BIG_NUM),
    max = new Array(row_len).fill(0),
    sum = new Array(row_len).fill(0);

for (var i = 0, row; row = table.rows[i]; i++) {
    for (var j = 1, cell; cell = row.cells[j]; j++) {
        var val = parseFloat(cell.innerHTML);
        if (isNaN(val))
            continue;

        if (j < 10) // bit cells
        {
            if (val == 1)
                cell.style.background = "rgb(239, 255, 116)"; // yellow
            else if (val == 2)
                cell.style.background = "rgb(255,77,77)"; // red (You can see that in exceptions.php)
        }

        if (val < min[j]) // Finding the minimum value of every column
            min[j] = val;

        if (val > max[j])
            max[j] = val;

        sum[j] += val; // For dividing the sum and getting the average
    }
}

var node = document.createElement("td");
node.innerHTML = table.rows.length - 5;
document.getElementById("count").appendChild(node);

for (var i = 1; i < row_len; i++) {
    // Creating an empty min-man-avg for not-a-number fields.
    if (isNaN(parseFloat(table.rows[5].cells[i].innerHTML))) {
        var rows = ["min", "max", "avg"];
        rows.forEach(function(entry) {
            node = document.createElement("td");
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
    node.innerHTML = (sum[i] / (table.rows.length - 5)).toFixed(2);
    document.getElementById("avg").appendChild(node);
}

function removeColumn(index) {
    for (var i = 1, row; row = table.rows[i]; i++) {
        row.deleteCell(index);
    }
}

// Adding remove buttons to every field
for (var j = 1, cell; cell = table.rows[4].cells[j]; j++) {
    var button = document.createElement("button");
    button.innerHTML = "remove";
    button.addEventListener("click", function(e) {
        removeColumn(e.target.parentElement.cellIndex);
    })
    cell.appendChild(document.createElement("br"))
    cell.appendChild(button)
}

// After the processing, hide the cat
document.getElementById("loader").hidden = true;