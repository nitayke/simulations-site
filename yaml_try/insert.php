<?php

include '../dbex/db_connect.php';

$conn = OpenCon();

$regular_fields = [];
$stats = [];
$table_name = '';

foreach ($_POST as $k => $v) {
    if (in_array($k, $parameters))
        $regular_fields[$k] = $v;
    else if ($k == 'table_name')
        $table_name = $v;
    else
        $stats[$k] = $v;
}

if ($table_name == '')
{
    echo "No table name";
    exit;
}

if (empty($stats)) {
    echo "No stats key value was received\n";
    $sql = "INSERT INTO $table_name (" . implode(', ', array_keys($regular_fields)) . ", stats) VALUES (\"" . implode('", "', array_values($regular_fields)) . "\", '')";
}
else {
    $sql = "INSERT INTO $table_name (" . implode(', ', array_keys($regular_fields)) . ", stats) VALUES (\"" . implode('", "', array_values($regular_fields)) . 
    "\", \"" . addslashes(serialize($stats)) . "\")";
    echo $sql . "\n";
}

if(mysqli_query($conn, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}

mysqli_close($conn);

?>