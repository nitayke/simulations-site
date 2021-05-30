<?php

$FILE_NAME = '../filters_config.txt';

if (isset($_GET['get_filters'])) {
    $file = fopen($FILE_NAME, 'r');
    $txt = fread($file, filesize($FILE_NAME));
    fclose($file);
    echo $txt;
}
else if (isset($_GET['set_filters']))
{
    $file = fopen($FILE_NAME, 'w');
    fwrite($file, $_GET['set_filters']);
    fclose($file);
}
else
{
    echo 'Nothing!';
}
?>