<?php
include './get_data.php';

$ending_reasons = [];

$resultSet = mysqli_query($conn, $sqlQuery) or die("<br>database error: ". mysqli_error($conn));

$dataPoints = [];

while( $developer = mysqli_fetch_assoc($resultSet) )
{
    $found = false;
    for ($i = 0; $i < count($dataPoints); $i++)
    {
        if ($dataPoints[$i]["label"] === $developer['ending_reason'])
        {
            $dataPoints[$i]["y"]++;
            $found = true;
            break;
        }
    }
    if (!$found)
    {
        array_push($dataPoints, array("label" => $developer['ending_reason'], "y" => 1));
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>

<link href="style.css" rel="stylesheet" type="text/css">


<style type="text/css">
body { background-color: #91ced4;}
</style>

<script>
window.onload = function() {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title: {
		text: "Ending Reasons Of Simulations"
	},
	subtitles: [{
		text: "Indoors 2021"
	}],
	data: [{
		type: "pie",
        indexLabel: "{label} (#percent%)",
        percentFormatString: "#0.##",
        toolTipContent: "{y} (#percent%)",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

}
</script>
</head>


<body>

<a href="/">
	<img src="drone.png" width="100"></a>

<script src="./javascript/table.js"></script>
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
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>      