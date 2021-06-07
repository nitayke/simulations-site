<!DOCTYPE HTML>
<html>
<head>
<title>Exceptions</title>
<?php
    include './get_data.php';

    $ending_reasons = [];

    $dataPoints = [];

    $row = 1;
    $index = -1;
    $handle = fopen("./table.csv", "r") or die("Unable to open file!");
    while (($data = fgetcsv($handle)) !== false) {
        if ($row === 1)
        {
            $index = array_search("ending reason", $data);
            $row++;
            continue;
        }
        if ($index === -1)
        {
            echo "wrong table.csv file!";
            exit;
        }
        
        $found = false;
        for ($i = 0; $i < count($dataPoints); $i++)
        {
            if ($dataPoints[$i]["label"] === $data[$index])
            {
                $dataPoints[$i]["y"]++;
                $found = true;
                break;
            }
        }
        if (!$found)
        {
            array_push($dataPoints, array("label" => $data[$index], "y" => 1));
        }


        $row++;
    }
    fclose($handle);

?>

<link href="style.css" rel="stylesheet" type="text/css">

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
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>