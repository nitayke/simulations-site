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

<br>
<br>

<div id='graph'></div>

<script>
var trace1 = {
  x: [1, 2, 3, 4],
  y: [10, 15, 13, 17],
  type: 'scatter',
  name: 'All', 
  line: {color: 'blue'}
};

var trace2 = {
  x: [1, 2, 3, 4],
  y: [16, 5, 11, 9],
  type: 'scatter',
  name: 'Good',
  line: {color: 'green'}
};

var trace3 = {
  x: [1, 2, 3, 4],
  y: [1, 2, 10, 4],
  type: 'scatter',
  name: 'Bad',
  line: {color: 'red'}
};

var data = [trace1, trace2, trace3];

Plotly.newPlot('graph', data);
</script>
</body>
</html>