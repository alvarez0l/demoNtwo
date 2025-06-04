<?php

require_once __DIR__.'/session.php';  //Импортируем файл Сессии

$_SESSION['user_id'] = null;  //Обнуляем user_id, чтобы сработала проверка аторизованного пользователя и вывела значение FALSE
header('Location: index.php');  //Переводим пользователя на главную страницу