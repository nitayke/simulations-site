<?php

function getReasons($table) {

    $ending_reasons = [];
    
    $conn = OpenCon();
    $sqlQuery = "SELECT DISTINCT ending_reason FROM `" . $table . "`";
    
    $resultSet = mysqli_query($conn, $sqlQuery) or die("<br>database error: ". mysqli_error($conn));
    
    $developer = mysqli_fetch_assoc($resultSet);
    if (is_null($developer))
        return;
    
    while ($developer = mysqli_fetch_assoc($resultSet))
        array_push($ending_reasons, $developer['ending_reason']);


    closecon($conn);
    return $ending_reasons;
}

?>