<!DOCTYPE HTML>
<html>
<head>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <title>Exceptions</title>
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





<!DOCTYPE HTML>
<html>
<head>
<title>Exceptions</title>
<link href="style.css" rel="stylesheet" type="text/css">
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
                if (strpos($field, " bit") !== false || strpos($field, "alive") !== false) {
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
</head>

<body>
</body>
</html>