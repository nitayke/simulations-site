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

<label>Tables:</label>
<select class="filter" onchange="selectChange(this)" id="table_choose">
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
<select id="parameter" onchange="graphParamChange(this)" class="filter">
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

<label>Number of columns:</label>
<input type="text" id="number_of_columns" class="filter">
<input type="button" value="Go" id="num_col_btn" class="button">
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
  x: [1, 2, 3, 4],
  y: [16, 5, 11, 9],
  name: 'Good',
  line: {color: 'green'}
};

var trace3 = {
  x: [1, 2, 3, 4],
  y: [1, 2, 10, 4],
  name: 'Bad',
  line: {color: 'red'}
};

var data = [trace1, trace2, trace3];

Plotly.newPlot('graph', data);
</script>

</body>
</html>