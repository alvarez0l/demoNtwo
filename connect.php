<?php

$host = "MySQL-8.2";
$username = "root";
$password = "";
$database = "db_rest";

$connectDB = new mysqli($host, $username, $password, $database);

if(!$connectDB) {
    die("Ошибка подключения: " . $connectDB->connect_error);
}