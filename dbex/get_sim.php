<?php

if (!isset($_GET['table']) || !isset($_GET['id']))
    exit("Wrong parameters!");


$username = "lambda-sim";
$password = "Aa123456";
$ip      = '10.42.149.53';
$remoteDir = "/home/$username/sandbox/indoors_server_farm/bags/$_GET[table]/$_GET[id]";
$localDir  = '../tmp_folder';

$connection = ssh2_connect($ip);

if (!ssh2_auth_password($connection, $username, $password)) 
    exit('Unable to connect.');

if (!$sftp = ssh2_sftp($connection)) 
    exit('Unable to create SFTP connection.');

// download all the files
$files = scandir('ssh2.sftp://' . $sftp . $remoteDir);
if (!empty($files)) {
    mkdir("$localDir/$_GET[id]");
    $localDir = "$localDir/$_GET[id]";
    foreach ($files as $file) {
        echo $file . "<br>";
        if ($file != '.' && $file != '..') {
            ssh2_scp_recv($connection, "$remoteDir/$file", "$localDir/$file");
        }
    }
}

// creating a tar.gz file
$pd = new PharData("$localDir/archive.tar");
$pd->buildFromDirectory($localDir);
$pd->compress(Phar::GZ);


// deleting all files in ../tmp_folder ($localDir) except archive.tar.gz
$files = glob("$localDir/{,.}*", GLOB_BRACE);
foreach($files as $file)
{
    if(is_file($file) && $file !== "$localDir/archive.tar.gz")
        unlink($file);
}

?>