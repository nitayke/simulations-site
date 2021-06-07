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
include './dbex/get_data.php';
include './dbex/variables.php';
?>

<body>


<a href="/">
	<img src="./images/drone.png" width="100">
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


<script src="./javascript/exceptions.js"></script>

<?php
    // $fields = [];
    // $row = 1;
    // $index = -1;

    // $handle = fopen("./table.csv", "r") or die("Unable to open file!");
    // while (($data = fgetcsv($handle)) !== false) {
    //     if ($row === 1)
    //     {
    //         foreach ($data as $field) {
    //             if (strpos($field, " bit") !== false || strpos($field, "alive") !== false) {
    //                 array_push($fields, $field);
    //                 echo $field . "<br>";
    //             }
    //         }
    //         continue;
    //     }
        
    //     $row++;
    // }
    // fclose($handle);

?>
</body>
</html>