<?php
// Connect to database
$db_host = 'localhost';
$db_name = 'cms4.2.1';
$db_user = 'root';
$db_pass = 'Softlips22';

// // Create object to connect
// $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

// // Handle errors
// if (mysqli_connect_errno()) {
//     echo 'This connection failed ' . $mysqli_connect_erro();
//     //cut everything off
//     die;
// }

$DSN = 'mysql:host =localhost; dbname=cms4.2.1';
$ConnectingDB = new PDO($DSN, $db_user, $db_pass);
