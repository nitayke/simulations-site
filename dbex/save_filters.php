<?php

$rawValue = file_get_contents('php://input');
$filters = json_decode($rawValue);


$file = fopen('../filters_config.txt', 'w');
fwrite($file, $filters->{'filters'});

fclose($file);
?>