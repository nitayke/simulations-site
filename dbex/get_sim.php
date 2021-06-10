<?php

$username = "lambda-sim";
$password = "Aa123456";
$ip      = '10.42.149.53';
$remoteDir = "/home/$username/sandbox/indoors_server_farm/bags/$_GET[table]/$_GET[id]";
$localDir  = '../tmp_folder';


if (!isset($_GET['table']) || !isset($_GET['id']))
{
    exit("No Parameters!"); 
}

$tar_name = "$localDir/$_GET[table]_$_GET[id].tar";

if (isset($_GET['delete']))
{
    // deleting all files in $localDir except archive.tar.gz
    $files = glob("$localDir/{,.}*", GLOB_BRACE);
    foreach($files as $file)
    {
        if(is_file($file))
            unlink($file);
    }
    exit("Deleted Successfully!");
}


$connection = ssh2_connect($ip);

if (!ssh2_auth_password($connection, $username, $password)) 
    exit('Unable to connect.');

if (!$sftp = ssh2_sftp($connection)) 
    exit('Unable to create SFTP connection.');

// download all the files
$files = scandir('ssh2.sftp://' . $sftp . $remoteDir);
if (!empty($files)) {
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            ssh2_scp_recv($connection, "$remoteDir/$file", "$localDir/$file");
        }
    }
}
else {
    exit("No such directory!");
}


// creating a tar.gz file
$pd = new PharData($tar_name);
$pd->buildFromDirectory($localDir);
$pd->compress(Phar::GZ);

?>