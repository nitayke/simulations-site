<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "elad", "Aa123456", "simulationdb");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Escape user inputs for security
// $ = mysqli_real_escape_string($link, $_REQUEST['ffk_bit']);

// // Attempt insert query execution
// // change ID to NULL in order to auto incerment 
// $sql = "INSERT INTO `test` (`ID`, `stats`) VALUES (NULL, '$stats')";


// var_dump($_REQUEST);

// $sql = "INSERT INTO `test` (`ID`, `stats`) VALUES (NULL, '$_REQUEST')";
// var_dump($_REQUEST);
$ID = mysqli_real_escape_string($link, $_REQUEST['ID']);
$escapedGet = array_map(array($link, 'real_escape_string'), $_REQUEST);
unset($escapedGet['ID']);
extract($escapedGet);

foreach (array_keys($escapedGet) as $key)
{
    print $key;
    print ":";
    print $escapedGet[$key];
    print " ";
}
print "------ID:";
print $ID;
$data = serialize($escapedGet);
print "\n";
var_dump($data);
print "\n";
print $data;
$sql = "INSERT INTO `test` (`ID`, `stats`) VALUES (NULL, '$data')";
if(mysqli_query($link, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
    
// Close connection
mysqli_close($link);
?>
