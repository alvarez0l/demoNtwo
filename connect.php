<?php

//Данные для подключения
$host = "MySQL-8.2";
$username = "root";
$password = "";
$database = "db_rest";

$connectDB = new mysqli($host, $username, $password, $database);  //Новое подключение к БД

if(!$connectDB) {  //Обработка ошибки подключения к БД
    die("Ошибка подключения: " . $connectDB->connect_error);
}