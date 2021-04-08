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
		indexLabel: "{label} ({y})",
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

<div class="pagination">
    <?php
    
    $result = mysqli_query($conn, "show tables");

    while($table = mysqli_fetch_array($result)) {
        if ($table[0] == $slide)
            echo("<a href=\"?table=" . $table[0] . "\" class=\"active\">" . $table[0] . "</a>");
        else
            echo("<a href=\"?table=" . $table[0] . "\">" . $table[0] . "</a>");
    }?>
</div>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>      