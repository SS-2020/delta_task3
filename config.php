<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'userdetails');
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$query="CREATE DATABASE IF NOT EXISTS userdetails";
if (mysqli_query($conn, $query));
else {
  echo "Error creating database: " . mysqli_error($conn);
}

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql1="CREATE TABLE IF NOT EXISTS `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
 `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `created_at` datetime DEFAULT current_timestamp(),
 PRIMARY KEY (`id`),
 UNIQUE KEY `username` (`username`)
)"; 
if (mysqli_query($link, $sql1));
else {
  echo "Error creating table: " . mysqli_error($link);
}
$sql2="CREATE TABLE IF NOT EXISTS `eventtable` (
 `no` int(11) NOT NULL AUTO_INCREMENT,
 `uid` int(11) NOT NULL,
 `uname` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
 `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
 `header` text COLLATE utf8mb4_unicode_ci NOT NULL,
 `venue` text COLLATE utf8mb4_unicode_ci NOT NULL,
 `date` date NOT NULL,
 `time` time NOT NULL,
 `footer` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `deadlinedate` date NOT NULL,
 `deadlinetime` time NOT NULL,
 PRIMARY KEY (`no`)
)";
if (mysqli_query($link, $sql2));
else {
  echo "Error creating table: " . mysqli_error($link);
}
$sql3="CREATE TABLE IF NOT EXISTS`invite` (
 `eno` int(11) DEFAULT NULL,
 `userid` int(11) DEFAULT NULL,
 `name` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `food` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `people` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `status` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `notify` int(4) NOT NULL DEFAULT 1
)";
if (mysqli_query($link, $sql3));
else {
  echo "Error creating table: " . mysqli_error($link);
}
?>

