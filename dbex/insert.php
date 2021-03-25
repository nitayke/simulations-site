<?php

// INSERT TO lab1 TABLE

include 'db_connect.php';

$conn = OpenCon();

$regular_fields = [];
$stats = [];

foreach ($_POST as $k => $v) {
    if (in_array($k, $parameters))
        $regular_fields[$k] = $v;
    else
        $stats[$k] = $v;
}

if (empty($stats)) {
    echo "No stats key value was received\n";
    $sql = "INSERT INTO lab1 (" . implode(', ', array_keys($_POST)) . ", stats) VALUES (\"" . implode('", "', array_values($_POST)) . "\", '')";
}
else {
    $sql = "INSERT INTO lab1 (" . implode(', ', array_keys($regular_fields)) . ", stats) VALUES (\"" . implode('", "', array_values($regular_fields)) . 
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