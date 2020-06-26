<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'userdetails');
 

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
/*
 	CREATE TABLE `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
 `password` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
 `created_at` datetime DEFAULT current_timestamp(),
 PRIMARY KEY (`id`),
 UNIQUE KEY `username` (`username`)
) 
CREATE TABLE `eventtable` (
 `no` int(11) NOT NULL AUTO_INCREMENT,
 `uid` int(11) NOT NULL,
 `uname` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
 `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
 `header` text COLLATE utf8mb4_unicode_ci NOT NULL,
 `venue` text COLLATE utf8mb4_unicode_ci NOT NULL,
 `date` date NOT NULL,
 `time` time NOT NULL,
 `footer` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 PRIMARY KEY (`no`)
)
 CREATE TABLE `invite` (
 `eno` int(11) DEFAULT NULL,
 `userid` int(11) DEFAULT NULL,
 `name` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `food` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `people` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `status` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL
)
 */
?>
