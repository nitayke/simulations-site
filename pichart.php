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
<script>
window.onload = function() {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title: {
		text: "Ending Reasons Of Simulations"
	},
	subtitles: [{
		text: "Indoors"
	}],
	data: [{
		type: "pie",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>      