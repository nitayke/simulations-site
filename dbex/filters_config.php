<?php

$FILE_NAME = '../filters_config.txt';

if (isset($_GET['set_filters']))
{
    $file = fopen($FILE_NAME, 'w');
    fwrite($file, $_GET['set_filters']);
    fclose($file);
}
else
    echo 'Wrong Usage!';

?>