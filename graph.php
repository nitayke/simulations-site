<!DOCTYPE HTML>
<html>
<head>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <title>Statistics Graph</title>
    <script src="./javascript/table.js"></script>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>

<?php
include './get_data.php';
include './variables.php';
?>


<a href="/">
	<img src="drone.png" width="100">
</a>
<br>
<label>Tables:</label>
<select class="menu" onchange="tableChange(this)" id="table_choose">
<?php
$result = mysqli_query($conn, "show tables");

while($table = mysqli_fetch_array($result)) {
    if ($table[0] == $slide)
        echo "<option selected>" . $table[0] . "</option>";
    else
        echo "<option>" . $table[0] . "</option>";
}?>
</select>
<label>Parameter:</label>
<select id="parameter" onchange="paramChange(this)" class="menu">
<option></option>
<?php
	foreach ($developer as $key => $val)
    {
        if (isset($_GET['param']) && $_GET['param'] === $key)
		    echo "<option selected>" . $key . "</option>";
        else
		    echo "<option>" . $key . "</option>";
    }
?>
</select>

<label>Accuracy:</label>
<input type="text" id="number_of_columns" class="menu">
<input type="button" value="Go" id="num_col_btn" class="button">
<label>(Default accuracy is 20)</label>
<br><br>
<input type="checkbox" id="all_cb" checked=true onclick="UpdatePlot()">
<label>All</label>
<input type="checkbox" id="good_cb" checked=true onclick="UpdatePlot()">
<label>Good</label>
<input type="checkbox" id="bad_cb" checked=true onclick="UpdatePlot()">
<label>Bad</label>
<br><br>

<div id='graph'></div>
<script src="./javascript/graph.js"></script>

<script>

var trace1 = {
  x: graph_x,
  y: graph_y,
  name: 'All', 
  line: {color: 'blue'}
};

var trace2 = {
  x: good_x,
  y: good_y,
  name: 'Good',
  line: {color: 'green'}
};

var trace3 = {
  x: bad_x,
  y: bad_y,
  name: 'Bad',
  line: {color: 'red'}
};

var data = [trace1, trace2, trace3];

var new_data = []

var checkboxes = []

UpdatePlot()

function UpdatePlot()
{
    new_data = []
    checkboxes = [document.getElementById('all_cb'), document.getElementById('good_cb'), document.getElementById('bad_cb')]

    for (var i = 0; i < 3; i++)
    {
        if (checkboxes[i].checked)
            new_data.push(data[i])
    }

    Plotly.newPlot('graph', new_data);
}
</script>

</body>
</html>