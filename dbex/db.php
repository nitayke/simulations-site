<?php
$dsn = "mysql:host=localhost;dbname=simulationdb";
$username= "elad";
$password = "Aa123456";

try {
    $db = new PDO($dsn, $username, $password);
    echo " You have Connected Suucssefuly";
} catch (PDOException $e) {
    $error_messege = $e->getMessage();
    echo $error_messege;
    exit();
    //throw $th;
}

?>
https://www.tutorialrepublic.com/php-tutorial/php-mysql-insert-query.php
https://www.w3schools.com/python/ref_requests_post.asp