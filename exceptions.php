<!DOCTYPE HTML>
<html>
<head>
<title>Exceptions</title>
<?php
    include './get_data.php';

    $fields = [];
    $row = 1;
    $index = -1;

    $handle = fopen("./table.csv", "r") or die("Unable to open file!");
    while (($data = fgetcsv($handle)) !== false) {
        if ($row === 1)
        {
            foreach ($data as $field) {
                if (strpos($field, "bit") !== false || strpos($field, "alive") !== false) {
                    array_push($fields, $field);
                    echo $field . "<br>";
                }
            }
            continue;
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