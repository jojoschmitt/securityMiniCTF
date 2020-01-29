<?php

$dbServerName = "database_mysql";
$dbUserName = "root";
$dbPassword = "kQh_Dö!!y82ÄIX&/s*80";
$dbName = "miniCTF";

$conn = mysqli_connect($dbServerName, $dbUserName, $dbPassword, $dbName)
OR die('Error connecting to MySQL service: '.mysqli_connect_error());

?>
